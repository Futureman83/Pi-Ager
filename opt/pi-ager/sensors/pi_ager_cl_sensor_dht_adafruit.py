# -*- coding: utf-8 -*-
 
"""This class is for handling the dht_adafruit sensor from sensirion."""

__author__ = "Claus Fischer"
__copyright__ = "Copyright 2019, The Pi-Ager Project"
__credits__ = ["Claus Fischer"]
__license__ = "GPL"
__version__ = "1.0.0"
__maintainer__ = "Claus Fischer"
__email__ = "DerBurgermeister@pi-ager.org"
__status__ = "Production"

import inspect
from main.pi_ager_cl_logger import cl_fact_logger
import time

import pi_ager_gpio_config

from sensors.pi_ager_cl_sensor_type import cl_fact_main_sensor_type
from main.pi_ager_cx_exception import *
from messenger.pi_ager_cl_messenger import cl_fact_logic_messenger
from sensors.pi_ager_cl_sensor import cl_sensor #
from sensors.pi_ager_cl_ab_sensor import cl_ab_sensor
import Adafruit_DHT

class cl_sensor_dht_adafruit(cl_sensor):
    
    def __init__(self, i_sensor_dht):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
  
        super().__init__(cl_fact_main_sensor_type.get_instance())
        
        self._pin = pi_ager_gpio_config.gpio_sensor_data            

        self._max_errors = 3
        self._old_temperature = 0
        self._current_temperature = 0
        self._temperature_dewpoint = 0
        self._humidity_absolute = 0
        self._old_humidity = 0
        self._current_humidity = 0

    def get_current_data(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        self._error_counter = 0
        
        while self._error_counter < self._max_errors:
            try:
                self._current_temperature = 0
                self._current_humidity = 0
                self._dewpoint = 0
                # Try to grab a sensor reading.  Use the read_retry method which will retry up
                # to <retries> times to get a sensor reading (waiting <delay_seconds> seconds between each retry).
                cl_fact_logger.get_instance().debug("Try to read from Sensor DHT%s Pin %s" % (self._sensor_dht, self._pin))
                self._current_humidity, self._current_temperature = Adafruit_DHT.read_retry(self._sensor_dht, self._pin, retries=5, delay_seconds=2)    
        
                if ( self._current_temperature == None or self._current_humidity == None ):
                    raise ValueError
                    
                cl_fact_logger.get_instance().debug("Temperature in Celsius is : %.2f °C" %self._current_temperature)
                cl_fact_logger.get_instance().debug("Relative Humidity is : %.2f %%RH" %self._current_humidity)
                self._dewpoint     = super().get_dewpoint(self._current_temperature, self._current_humidity)
        
                (temperature_dewpoint, humidity_absolute) = self._dewpoint
                self.measured_data = (self._current_temperature, self._current_humidity, temperature_dewpoint, humidity_absolute)
                return(self.measured_data)                    
            
            except Exception as cx_error:
                self._error_counter = self._error_counter + 1
                if (self._error_counter == 1):
                    cl_fact_logger.get_instance().exception(cx_error)
                else:
                    cl_fact_logger.get_instance().error(f"Retry getting measurement from DHT device. Current retry count : {self._error_counter}, max retry count : {self._max_errors}")        
                time.sleep(1)
        
#        self.delete_error_counter() 
        cl_fact_logger.get_instance().debug('Too many measurement errors occurred!')
        raise cx_measurement_error (_('Too many measurement errors occurred!'))    
   
    def _write_to_db(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        super()._write_to_db()
        pass

    def execute(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        #self.get_current_data()
        self._write_to_db()
        
    def set_heading_on(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        cl_fact_logger.get_instance().debug('Not avaiable for this sensor type')
    
    def set_heading_off(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        cl_fact_logger.get_instance().debug('Not avaiable for this sensor type')
    
    def soft_reset(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        cl_fact_logger.get_instance().debug('Not avaiable for this sensor type')
        
class th_sensor_dht_adafruit(cl_sensor_dht_adafruit):
#    SUPPORTED_MAIN_SENSOR_TYPES = ["dht_adafruit", "dht_adafruit", "DHT22"]
    NAME = 'Main_sensor'
    
    
    def __init__(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        self.get_type_raise = False
        self._type = "dht_adafruit"
        
    def get_type(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        if self.get_type_raise == True:
            raise cx_Sensor_not_defined(self._type_ui)        
        return(self._type)

    
