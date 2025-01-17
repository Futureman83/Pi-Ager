# -*- coding: utf-8 -*-
 
"""This class is for handling the SHT75 sensor from sensirion."""

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
import pi_sht1x
import pi_ager_gpio_config

from sensors.pi_ager_cl_sensor_type import cl_fact_main_sensor_type
from main.pi_ager_cx_exception import *
from messenger.pi_ager_cl_messenger import cl_fact_logic_messenger
from sensors.pi_ager_cl_sensor import cl_sensor
from sensors.pi_ager_cl_ab_sensor import cl_ab_sensor

class cl_sensor_sht75(cl_sensor):
    
    def __init__(self, i_sensor_type, i_active_sensor):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        if "get_instance" not in inspect.stack()[1][3]:
            raise cx_direct_call(self,"Please use factory class" )
        self.o_sensor_type = i_sensor_type
        self._error_counter = 0            
        self._max_errors = 5
        self._old_temperature = 0
        self._current_temperature = 0
        self._temperature_dewpoint = 0
        self._humidity_absolute = 0
        self._old_humidity = 0
        self._current_humidity = 0
        
        self._sensor_sht = pi_sht1x.SHT1x(pi_ager_gpio_config.gpio_sensor_data, pi_ager_gpio_config.gpio_sensor_sync, gpio_mode=pi_ager_gpio_config.board_mode)
                
   
    def get_current_data(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        self.delete_error_counter()
        while self._error_counter < self._max_errors:
        
            try:
                self._current_temperature = self._get_current_temperature()
                self._current_humidity    = self._get_current_humidity()
                self._dewpoint            = super().get_dewpoint(self._current_temperature, self._current_humidity)
                cl_fact_logger.get_instance().debug("sht75 temperature : %.2f °C" % self._current_temperature)
                cl_fact_logger.get_instance().debug("sht75 humidity : %.2f %%RH" % self._current_humidity)
        
                (temperature_dewpoint, humidity_absolute) = self._dewpoint
        
                self.measured_data = (self._current_temperature, self._current_humidity, temperature_dewpoint, humidity_absolute)
                return(self.measured_data)
                
            except Exception as cx_error:
                self._error_counter = self._error_counter + 1
                if (self._error_counter == 1):
                    cl_fact_logger.get_instance().exception(cx_error)
                else:
                    cl_fact_logger.get_instance().error(f"Retry getting measurement from SHT75. Current retry count : {self._error_counter}, max retry count : {self._max_errors}")       

#        self.delete_error_counter()
        cl_fact_logger.get_instance().debug('Too many measurement errors occurred!')
        raise cx_measurement_error(_('Too many measurement errors occurred!'))
        
    def _get_current_temperature(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())

        self._sensor_sht.read_temperature()
        
        Temperature_Celsius    = self._sensor_sht.temperature_celsius
        Temperature_Fahrenheit = self._sensor_sht.temperature_celsius * 9/5 + 32

        # cl_fact_logger.get_instance().debug("Temperature in Celsius is : %.2f °C" %Temperature_Celsius)
        # cl_fact_logger.get_instance().debug("Temperature in Fahrenheit is : %.2f F" %Temperature_Fahrenheit)
        
        self._current_temperature = Temperature_Celsius
        
        if self._old_temperature is None:
            self._old_temperature = 0
        else:
            self._old_temperature = self._current_temperature
            
        return(self._current_temperature)
  
    def _get_current_humidity(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())

        self._sensor_sht.read_humidity()
        
        Humidity = self._sensor_sht.humidity

        # cl_fact_logger.get_instance().debug("Relative Humidity is : %.2f %%RH" %Humidity)
        
        self._current_humidity = Humidity
        
        if self._old_humidity is None:
            self._old_humidity = 0
        else:
            self._old_humidity = self._current_humidity

        return(self._current_humidity)
   
    def _write_to_db(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        super()._write_to_db()
        pass

    def soft_reset(self):
        """Performs Soft Reset on SHT chip"""
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        
        
    def set_heading_on(self):
        """Switch the heading on the sensor on"""
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())

    
    def set_heading_off(self):
        """Switch the heading on the sensor off"""
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())


    def execute(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        #self.get_current_data()
        self._write_to_db()
        
class th_sensor_sht75(cl_sensor_sht75):
#    SUPPORTED_MAIN_SENSOR_TYPES = ["SHT75", "DHT11", "DHT22"]
    NAME = 'Main_sensor'
    
    
    def __init__(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        self.get_type_raise = False
        self._type = "SHT75"
        
    def get_type(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        if self.get_type_raise == True:
            raise cx_Sensor_not_defined(self._type_ui)        
        return(self._type)

    
class cl_fact_sensor_sht75: 
    #fact_main_sensor_type = cl_fact_main_sensor_type()
#    Only a singleton instance for main_sensor
    #__o_sensor_type = fact_main_sensor_type.get_instance()
    __o_instance = None

    @classmethod        
    def get_instance(self, i_sensor_type, i_active_sensor):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        if cl_fact_sensor_sht75.__o_instance is not None:
            return(cl_fact_sensor_sht75.__o_instance)
        cl_fact_sensor_sht75.__o_instance = cl_sensor_sht75(i_sensor_type, i_active_sensor)
        return(cl_fact_sensor_sht75.__o_instance)

    @classmethod
    def set_instance(self, i_instance):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        cl_fact_sensor_sht75.__o_instance = i_instance
    
    
    def __init__(self):
        cl_fact_logger.get_instance().debug(cl_fact_logger.get_instance().me())
        pass    

