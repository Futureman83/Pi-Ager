import asyncio
import binascii
#import logging

from main.pi_ager_cl_logger import cl_fact_logger
#logger = logging.getLogger("nextion").getChild(__name__)


class BasicProtocol(asyncio.Protocol):
    def __init__(self):
        self.transport = None
        self.queue = asyncio.Queue()
        self.connect_future = asyncio.get_event_loop().create_future()
        self.disconnect_future = asyncio.get_event_loop().create_future()

    async def close(self):
        if self.transport:
            self.transport.close()

        await self.disconnect_future

    async def wait_connection(self):
        await self.connect_future

    def connection_made(self, transport):
        self.transport = transport
        cl_fact_logger.get_instance().info("Connected to serial")
        self.connect_future.set_result(True)

    def data_received(self, data):
        cl_fact_logger.get_instance().debug("received: %s", binascii.hexlify(data))
        self.queue.put_nowait(data)

    def read_no_wait(self) -> bytes:
        return self.queue.get_nowait()

    async def read(self) -> bytes:
        return await self.queue.get()

    def write(self, data: bytes, eol=True):
        assert isinstance(data, bytes)
        self.transport.write(data)
        cl_fact_logger.get_instance().debug("sent: %d bytes", len(data))

    def connection_lost(self, exc):
        cl_fact_logger.get_instance().error("Connection lost")
        if not self.connect_future.done():
            self.connect_future.set_result(False)
        # self.connect_future = asyncio.get_event_loop().create_future()
        if not self.disconnect_future.done():
            self.disconnect_future.set_result(True)
