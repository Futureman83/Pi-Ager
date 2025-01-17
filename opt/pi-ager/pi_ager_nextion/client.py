import asyncio
import binascii
#import logging
import os,stat
import struct
import typing
from collections import namedtuple
from io import BufferedReader

import serial_asyncio

from .constants import BAUDRATES, IO_TIMEOUT
from .exceptions import CommandFailed, CommandTimeout, ConnectionFailed
from .protocol import BasicProtocol, EventType, NextionProtocol, ResponseType
    
import pi_ager_names
import pi_ager_database
from main.pi_ager_cl_logger import cl_fact_logger

#logger = logging.getLogger("nextion").getChild(__name__)
# set log level
#logger.setLevel(logging.DEBUG)

# define file handler and set formatter
# logfile = '/var/www/logs/nextion.log'
# logf = open(logfile, "ab")
# logf.close()
# os.chmod(logfile, stat.S_IWOTH|stat.S_IWGRP|stat.S_IWUSR|stat.S_IROTH|stat.S_IRGRP|stat.S_IRUSR)

# file_handler = logging.FileHandler(logfile)
# formatter    = logging.Formatter('%(asctime)s : %(levelname)s : %(name)s : %(message)s')
# file_handler.setFormatter(formatter)

# add file handler to logger
# logger.addHandler(file_handler)
cl_fact_logger.get_instance().debug("logging initialized")

TouchDataPayload = namedtuple("Touch", "page_id component_id touch_event")
TouchCoordinateDataPayload = namedtuple("TouchCoordinate", "x y touch_event")


class Nextion:
    def __init__(
        self,
        url: str,
        baudrate: int = None,
        event_handler: typing.Callable[[EventType, any], None] = None,
        loop=asyncio.get_event_loop(),
        reconnect_attempts: int = 3,
        encoding: str = "ascii",
    ):
        self._loop = loop

        self._url = url
        self._baudrate = baudrate
        self._connection = None
        self._command_lock = asyncio.Lock()
        self.event_handler = event_handler or (
            lambda t, d: cl_fact_logger.get_instance().debug("Event %s data: %s" % (t, str(d)))
        )
        self.reconnect_attempts = reconnect_attempts
        self.encoding = encoding

        self._sleeping = True
        self.sets_todo = {}

    async def on_startup(self):
        await self.command("bkcmd=3")  # Let's ensure we receive expected responses

    async def on_wakeup(self):
        cl_fact_logger.get_instance().debug('Updating variables after wakeup: "%s"', str(self.sets_todo))
        for k, v in self.sets_todo.items():
            self._loop.create_task(self.set(k, v))
        self.sets_todo = {}
        self._sleeping = False

    def event_message_handler(self, message):
        cl_fact_logger.get_instance().debug("Handle event: %s", message)

        typ = message[0]
        # cl_fact_logger.get_instance().debug("event: 0x%02x", typ)
        if typ == EventType.TOUCH:  # Touch event
            self.event_handler(
                EventType(typ),
                TouchDataPayload._make(struct.unpack("BBB", message[1:])),
            )
        elif typ == EventType.TOUCH_COORDINATE:  # Touch coordinate
            self.event_handler(
                EventType(typ),
                TouchCoordinateDataPayload._make(struct.unpack("HHB", message[1:])),
            )
        elif typ == EventType.TOUCH_IN_SLEEP:  # Touch event in sleep mode
            self.event_handler(
                EventType(typ),
                TouchCoordinateDataPayload._make(struct.unpack("HHB", message[1:])),
            )
        elif typ == EventType.AUTO_SLEEP:  # Device automatically enters into sleep mode
            self._sleeping = True
            self.event_handler(EventType(typ), None)
        elif typ == EventType.AUTO_WAKE:  # Device automatically wake up
            self._loop.create_task(self.on_wakeup())
            self.event_handler(EventType(typ), None)
        elif typ == EventType.STARTUP:  # System successful start up
            self._sleeping = False
            self._loop.create_task(self.on_startup())
            self.event_handler(EventType(typ), None)
        elif typ == EventType.SD_CARD_UPGRADE:  # Start SD card upgrade
            self.event_handler(EventType(typ), None)
        else:
            cl_fact_logger.get_instance().warning("Other event: 0x%02x", typ)

    def _make_protocol(self) -> NextionProtocol:
        return NextionProtocol(event_message_handler=self.event_message_handler)

    async def _connect_at_baud(self, baud):
        delay_between_connect_attempts = (1000000 / baud + 30) / 1000

        cl_fact_logger.get_instance().info("Connecting: %s, baud: %s", self._url, baud)
        try:
            await self._create_serial_connection(baud)
        except OSError as e:
            if e.errno == 2:
                raise ConnectionFailed("Failed to open serial connection: %s" % e)
            else:
                cl_fact_logger.get_instance().warning("Baud %s not supported: %s", baud, e)
                return False

        await self._connection.wait_connection()

        self.write_command(
            "DRAKJHSUYDGBNCJHGJKSHBDN"
        )  # exit active Protocol Reparse and return to passive mode
        try:
            await self.read_packet(
                timeout=delay_between_connect_attempts
            )  # We do not care what response will be here
        except asyncio.TimeoutError:
            pass

        await asyncio.sleep(delay_between_connect_attempts)  # (1000000/baud rate)+30ms

        result = await self._attempt_connect_messages(delay_between_connect_attempts)

        if result:
            return result
        else:
            cl_fact_logger.get_instance().warning("No valid reply on %d baud. Closing connection", baud)
            await self._connection.close()
            return False

    async def _attempt_connect_messages(self, delay_between_connect_attempts):
        result = None
        for connect_message in [
            b"connect",  # traditional connect instruction
            b"\xff\xffconnect",  # connect instruction using the broadcast address of 65535
        ]:
            self.write_command(connect_message)
            try:
                result = await self.read_packet(timeout=delay_between_connect_attempts)
                if result[:6] == b"comok ":
                    break
                else:
                    cl_fact_logger.get_instance().warning("Wrong reply %s to connect attempt", result)
            except asyncio.TimeoutError:
                pass  # Attempt a next method
        return result

    async def _create_serial_connection(self, baud):
        _, self._connection = await serial_asyncio.create_serial_connection(
            self._loop, self._make_protocol, url=self._url, baudrate=baud
        )

    async def connect(self) -> None:
        try:
            result = await self._try_connect_on_different_baudrates()

            data = result[7:].decode().split(",")
            cl_fact_logger.get_instance().info(
                "Address: %s", data[1]
            )  # <unknown>-<address>, if address then all commands need to be
            # prepended with address. See https://nextion.tech/2017/12/08/nextion-hmi-upload-protocol-v1-1/
            cl_fact_logger.get_instance().info("Detected model: %s", data[2])
            cl_fact_logger.get_instance().info("Firmware version: %s", data[3])
            cl_fact_logger.get_instance().info("Serial number: %s", data[5])
            cl_fact_logger.get_instance().info("Flash size: %s", data[6])

            try:
                await self._command("bkcmd=3", attempts=1)
            except CommandTimeout as e:
                pass  # it is fine

            await self._update_sleep_status()

            cl_fact_logger.get_instance().info("Successfully connected to the device")
        except ConnectionFailed:
            cl_fact_logger.get_instance().exception("Connection failed")
            raise
        except:
            cl_fact_logger.get_instance().exception("Unexpected exception during connect")
            raise

    async def _update_sleep_status(self):
        self._sleeping = bool(await self._command("get sleep"))
        # cl_fact_logger.get_instance().info("update sleep mode = " + str(self._sleeping))
        
    async def _try_connect_on_different_baudrates(self):
        baudrates = self._get_priority_ordered_baudrates()

        for baud in baudrates:
            result = await self._connect_at_baud(baud)
            if result:
                self._baudrate = baud
                break
            else:
                cl_fact_logger.get_instance().warning("Baud %d did not work", baud)
        else:
            raise ConnectionFailed("No baud rate suited")
        return result

    def _get_priority_ordered_baudrates(self):
        baudrates = BAUDRATES.copy()
        if self._baudrate:  # if a baud rate specified put it first in array
            try:
                baudrates.remove(self._baudrate)
            except ValueError:
                pass
            baudrates.insert(0, self._baudrate)
        return baudrates

    async def reconnect(self):
        await self._connection.close()
        await self.connect()

    async def disconnect(self) -> None:
        await self._connection.close()

    async def read_packet(self, timeout=IO_TIMEOUT) -> bytes:
        return await asyncio.wait_for(self._connection.read(), timeout=timeout)

    async def get(self, key, timeout=IO_TIMEOUT):
        return await self.command("get %s" % key, timeout=timeout)

    async def set(self, key, value, timeout=IO_TIMEOUT):
        if isinstance(value, str):
            out_value = '"%s"' % value
        elif isinstance(value, float):
            cl_fact_logger.get_instance().warning("Float is not supported. Converting to string")
            out_value = '"%s"' % str(value)
        elif isinstance(value, int):
            out_value = str(value)
        else:
            raise AssertionError(
                'value type "%s" is not supported for set' % type(value).__name__
            )

        if self._sleeping and key not in ["sleep"]:
            cl_fact_logger.get_instance().debug(
                'Device sleeps. Scheduling "%s" set for execution after wakeup', key
            )
            # self.sets_todo[key] = value
        else:
            return await self.command("%s=%s" % (key, out_value), timeout=timeout)

    async def _command(self, command: str, timeout=IO_TIMEOUT, attempts=None):
        assert attempts is None or attempts > 0

        attempts_remained = attempts or self.reconnect_attempts
        last_exception = None
        while attempts_remained > 0:
            attempts_remained -= 1
            # cl_fact_logger.get_instance().debug("Attempts remained : %d", attempts_remained)
            if isinstance(last_exception, CommandTimeout):
                try:
                    cl_fact_logger.get_instance().info("Reconnecting")
                    await self.reconnect()
                    last_exception = None
                except ConnectionFailed:
                    cl_fact_logger.get_instance().error("Reconnect failed")
                    await asyncio.sleep(1)
                    continue

            self.flush_read_buffer()

            self.write_command(command)

            result = None
            data = None
            finished = False

            while not finished:
                try:
                    response = await self.read_packet(timeout=timeout)
                except asyncio.TimeoutError as e:
                    cl_fact_logger.get_instance().error('Command "%s" timeout.', command)
                    last_exception = CommandTimeout(
                        'Command "%s" response was not received' % command
                    )
                    await asyncio.sleep(IO_TIMEOUT)
                    break

                res_len = len(response)
                if res_len == 0:
                    finished = True
                    if result is None:
                        result = True
                elif res_len == 1:  # is response code
                    response_code = response[0]
                    if response_code == 0x01:  # success
                        result = True
                        finished = True
                    else:
                        raise CommandFailed(command, response_code)
                else:
                    type_ = response[0]
                    raw = response[1:]
                    if type_ == ResponseType.PAGE:  # Page ID
                        data = raw[1]
                    elif type_ == ResponseType.STRING:  # string
                        data = raw.decode(self.encoding)
                    elif type_ == ResponseType.NUMBER:  # number
                        data = struct.unpack("i", raw)[0]
                    else:
                        cl_fact_logger.get_instance().error(
                            "Unknown data received: %s" % binascii.hexlify(response)
                        )
                    if command.partition(" ")[0] in ["get", "sendme"]:
                        finished = True
            else:  # this will run if loop ended successfully
                # cl_fact_logger.get_instance().info('_command returned')
                return data if data is not None else result

        if last_exception is not None:
            # cl_fact_logger.get_instance().info('_command returned with exception')
            raise last_exception
            
      
    def write_command(self, command):
        if not isinstance(command, typing.ByteString):
            command = command.encode(self.encoding)

        self._connection.write(command)

    def flush_read_buffer(self):
        try:
            while True:
                cl_fact_logger.get_instance().debug("Flushing message: %s", self._connection.read_no_wait())
        except asyncio.QueueEmpty:
            pass

    async def command(self, command: str, timeout=IO_TIMEOUT, attempts=None):
        # cl_fact_logger.get_instance().info('Start command lock')
        async with self._command_lock:
            return await self._command(command, timeout=timeout, attempts=attempts)
        
    def is_sleeping(self):
        return self._sleeping

    async def sleep(self):
        if self._sleeping:
            return
        await self.set("sleep", 1)
        self._sleeping = True

    async def wakeup(self):
        if not self._sleeping:
            return
        await self.set("sleep", 0)
        await self.on_wakeup()

    async def dim(self, val: int):
        assert 0 <= val <= 100
        await self.set("dim", val)

    def _make_upload_protocol(self) -> BasicProtocol:
        return BasicProtocol()

    async def upload_firmware(self, file: BufferedReader, upload_baud=None):
        upload_baud = upload_baud or self._baudrate
        assert upload_baud in BAUDRATES

        file_size = os.fstat(file.fileno()).st_size

        cl_fact_logger.get_instance().info("About to upload %d bytes" % (file_size))
        await self.set("sleep", 0)
        await asyncio.sleep(0.15)
        try:
            await self.set("usup", 1)
            await self.set("ussp", 0)
        except CommandFailed as e:
            cl_fact_logger.get_instance().warning("Additional sleep configuration failed: %s" % str(e))

        self.write_command("whmi-wri %d,%d,0" % (file_size, upload_baud))
        cl_fact_logger.get_instance().info("Reconnecting at new baud rate: %d" % (upload_baud))
        await self._connection.close()
        _, self._connection = await serial_asyncio.create_serial_connection(
            self._loop, self._make_upload_protocol, url=self._url, baudrate=upload_baud
        )

        res = await self.read_packet(timeout=1)
        if res != b"\x05":
            raise IOError(
                "Wrong response to upload command: %s" % binascii.hexlify(res)
            )

        cl_fact_logger.get_instance().info("Device is ready to accept upload")

        uploaded_bytes = 0
        chunk_size = 4096
        uploaded_percentage = -1
        while True:
            buf = file.read(chunk_size)
            if not buf:
                break
            self._connection.write(buf, eol=False)

            timeout = len(buf) * 12 / self._baudrate + 1
            res = await self.read_packet(timeout=timeout)
            if res != b"\x05":
                raise IOError(
                    "Wrong response while uploading chunk: %s" % binascii.hexlify(res)
                )

            uploaded_bytes += len(buf)
            uploaded_percentage_tmp = int(uploaded_bytes / file_size * 500) # every 0.2 %
            if uploaded_percentage_tmp != uploaded_percentage:
                uploaded_percentage = uploaded_percentage_tmp
                cl_fact_logger.get_instance().info("Uploaded: %.1f %%" % (uploaded_percentage/5.0))
                pi_ager_database.update_nextion_table(uploaded_percentage, "running") # every 0.2 % 
                
        cl_fact_logger.get_instance().info("Successfully uploaded %d bytes" % uploaded_bytes)
        pi_ager_database.update_nextion_table(500, "success")
        