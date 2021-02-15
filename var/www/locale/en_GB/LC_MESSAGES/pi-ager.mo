��          �            x     y     �     �     �     �     �          .     D     \     q     �     �     �     �  q  �  i   e  �  �  !  q  �  �
  �  ,  O  �  �   &          �  /  7  (%  �  `+  �	  L-  �  �6  2  �=                            
             	                                      helptext_agingtable_config helptext_circulation_air helptext_dehumidifier_config helptext_exhausting_air helptext_humidify_config helptext_humidity_setpoint helptext_language_admin helptext_light_config helptext_operation_mode helptext_scale_admin helptext_sensortype_admin helptext_temperature_config helptext_temperature_setpoint helptext_thermometer_admin helptext_uv_config Project-Id-Version: Pi-Ager-EN
PO-Revision-Date: 2021-02-10 10:23+0100
Last-Translator: 
Language-Team: 
Language: en_GB
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 2.4.2
X-Poedit-Basepath: ../../###GITHUB/branches/entwicklung/var/www
Plural-Forms: nplurals=2; plural=(n != 1);
X-Poedit-SearchPath-0: .
 <br><br>
<b>failure humidity delta: </b> Text.
<br><br>
<b>failure temperature delta: </b> Text.
<br><br> <br><br>
<b>period: </b> this is used to set the pause time, which waits until the exhausting is switched on again. if the .lue is 0 (= no pause), the exhausting air is permanently switched on. the maximum value is 1440min.
<br><br>
<b>duration: </b> this sets the exhausting time during which the fan is running. at 0, the exhausting air timer function is switched off. the maximum value is 1440min.
<br><br>
<b>note: </b>  The exhaust air fan runs independently of the timer settings - also during dehumidification in the "automatic mode with humidification and dehumidification.
<br><br>
<b>attention: </b> period=0 und duration=0 is not useful and not allowed.
<br><br> <br><br>
<b>only exhaust: </b> Because passive dehumidification by exhaust air takes place in this mode, the effectiveness of the dehumidification is very dependent on the ambient air humidity.
<br><br>
<b>exhaust & dehumidifier: </b> In this mode, dehumidification via exhaust air is active together with a separate dehumidifier.
<br><br>
<b>only dehumidifier:</b> In this mode, the dehumidification of the air in the Pi-ager is performed only by a dehumidifier.
<br><br>
<b>recommendation:</b> The delay time in humidity control is not active on the dehumidifier, it only affects the humidifier..
<br><br>
<b>attention: </b> Since there are very few dehumidifiers on the market that are effective at the low temperatures, you should carefully consider which device you want to use for what.
<br><br> <br><br>
<b>period: </b> this is used to set the pause time, which waits until the exhausting is switched on again. if the .lue is 0 (= no pause), the exhausting air is permanently switched on. the maximum value is 1440min.
<br><br>
<b>duration: </b> this sets the exhausting time during which the fan is running. at 0, the exhausting air timer function is switched off. the maximum value is 1440min.
<br><br>
<b>note: </b>  The exhaust air fan runs independently of the timer settings - also during dehumidification in the "automatic mode with humidification and dehumidification.
<br><br>
<b>attention: </b> period=0 und duration=0 is not useful and not allowed. <br><br>
<b>switching hysteresis:</b>
<br><br>
<b>switch-on value: </b> is the value at which the control becomes active (value: 0-30%)
<b>switch-off value: </b>  is the value at which the control becomes inactive (value: 0-30%)
<br>the values may not be the same in order to avoid a wild switching on and off.
<br><br>
<b>delay: </b>here the delay time is set until the humidifier turns on if the humidity is too low. this can be used to blast out the rapidly falling air humidity during "cooling", "timer exhaust" or "dehumidification". The minimum value is 0 minutes, the maximum 60 minutes.
<br><br>
<b>example </b></b><i> target humidity: 75% ; switch-on value: 5% ; switch-off value: 1%</i>
<br>switch-on humidity = target humidity - switch-on value --> 75% - 5% = 70%
<br>switch-off humidity = target humidity - switch-off value--> 75% - 1% = 74%
<br>delay = 5 minutes
<br>so if 70% relative humidity are reached, the control waits for 5 minutes. only then does the pi-ager humidify the air to 74% and then switch off humidification again.
<br><br>
<b>example automatic mode with with humidification and dehumidification: </b> in this automatic mode, the humidity is completely automatically controlled. the current humidity is determined first. it is then decided which method (humidification and dehumidification) is suitable for achieving the desired set-point humidity. this also means that the switching values of the hysteresis must not be too close together. otherwise, humidification and dehumidification could always be switched on and off alternately.
<br><br>
<b>recommendation:</b> check the stored values in the logfile!
<br><br>
<b>attention: </b> use only positive integers!
<br><br> <br><br>
<b>target humidity: </b> the desired humidity is set here.
<br>The minimum value is theoretically 0% and a maximum of 99%. these values will be never reached normally. The circulating air is always active during humidification. 
<br>The effectiveness of the dehumidification (automatic mode with with humidification and dehumidification) is dependent on the ambient air humidity, since only a passive dehumidification by exhaust air takes place.
<br><br>
<b>recommendation: </b> check the stored values in the logfile!
<br><br>
<b>attention! </b> se only positive integers!
<br><br> <br><br>
<b>Language: </b> Here you can set the desired languages for the system.
<br><br>
<br><b>Attention! </b> For the language settings to work, the appropriate language pack must be installed on the Rasperry Pi!
<br><br> <br><br>
<b>period: </b> This is used to set the pause time, which waits until the light is switched on again. If the value is 0 (= no pause), the light is permanently switched on. The maximum value is 1440min.
<br><br>
<b>duration: </b> This sets light time during which the light is switched on. At 0, the light timer function is switched off. The maximum value is 1440min.
<br><br>
<b>timestamp: </b> As an alternative to the cycle, a fixed time can be set here at which the light is switched on for the set duration.
<br><br>
<b>note: </b>  You can manually switch on the light permanently via a switch on the webcampage.In this case, the timer can no longer turn off the light.
<br><br>
<b>attention: </b> period=0 und duration=0 is not useful and not allowed.
<br><br> <br><br>
<b>0 - cooling: </b> It is cooled to the set temperature with circulating air.
<br><br>
<b>1 - cooling with humidification: </b> It is cooled to the set temperature with circulating air and humidification is on,the heating is never controlled.
<br><br>
<b>2 - heating with humidification: </b> It is heated to the set temperature with circulating air and humidification is on, the cooling is never controlled.
<br><br>
<b>3 - automatik with humidification: </b> The pi-ager cools or heats with circulating air, depending on the set value and humidification is on.
<br><br>
<b>4 - automatik with dehumidification and humidification </b>Like automatic with humidification, additionally: If the humidity is exceeded, the exhaust air or/and the dehumidifier switches on until the humidity setpoint is reached again. Since the mode "only exhaust air" is a passive dehumidification, the minimum achievable humidity depends on the dryness of the ambient air. to avoid a wild switching on and off, the humidification should be delayed (5-10min)!
<br><br> <br><br>
<b><u>Load cell setting parameters: </u></b>
<br><br>
<b>Reference Unit: </b> The specific characteristic value of the load cell used is entered here.
<br>On the settings page, the exact value for the reference unit of the load cell used can be determined with the help of the scale wizard.
<br><br>
<b>measuring interval: </b> recommended value: 300s
<Br>Here you can set the cycle in which the weight is to be recorded. Too small intervals do not make sense and lead to an increased load on the system. 
<br><br>
<b>measuring time: </b> recommended value: 5s
<br>The measuring duration must be selected so that the number of raw samples can be recorded at least once. The system measures with a frequency of approx. 10Hz. ( approx. 10 raw measurement values per sec.).
<br> A rough rule of thumb: measuring duration = samples * 0.15 (always round up to whole numbers) 
<br><br>
<b>Storage cycle: </b> more recommended value: measuring duration + 3s (For this value applies in principle: storage cycle > measuring duration)
<br>Here you can set the cycle in which you save the values to the database within the measuring period.
Normally, the value should always be selected to be minimally greater than the measuring duration. In this case, a value is stored in the database in each measuring interval.
If this value is smaller than the measuring duration, a value is stored in the set cycle (during the measuring duration). This setting is only necessary for test purposes. 
<br><br>
<b>Samples: </b> recommended value: 20
<br> Here you can set how many raw measurements are used to determine a measured value.
<br><br>
<b>Typical Ref. Unit Werte: </b>
<br>10KG China Zelle: 205
<br>20kg China Zelle: 102
<br>50kg Edelstahl Zelle: 74
<br>20kg Edelstahl Zelle: 186
<br><br> <br><br>
<b>Sensor intern: </b> Here you can select the sensor to control the temperature and humidity in the Pi-Ager.
The older 1Wire sensors DHT11/22 and SHT75 as well as the newer I2C sensors (Bus Adr.44) can be used.
<br><br>
<b>Sensor extern: </b>It is possible to connect another sensor to the system. The external sensor can be used to monitor the external environmental conditions of the Pi-Ager. The external temperature and humidity can be used as a source of information, especially for the control of humidity in the Pi-Ager.
<br>It should be noted that currently only the SHT3X sensors can have their I2C bus address changed. Therefore only these sensors can be used as external sensors.
<br>With the help of an external circuit, e.g. with a 10kOhm resistor, the bus address of the SHT3x sensor can be changed to the required addr. 45. Some SHT3X sensor boards are also equipped with a corresponding jumper.
<br><br>
<b>Remark: </b> The connection of 2 sensors is only possible if you use the new I2C sensors. The external sensor is connected in parallel to the internal sensor to the corresponding terminals of the Pi-Ager board.
<br>For the connection of the sensors always shielded cables must be used, e.g. USB cables or Ethernet cables. The length of the sensor cable should not exceed 1.5m. It is important that the shield of the sensor lines is always connected on the Pi-Ager board side.
<br><br>
<b>Attention: </b> The connection of a sensor may only be done in a de-energized state, otherwise there is a risk of short circuit and the Raspberry can be damaged.
<br><br> <br><br>
<b>switch-on value: </b>  is the value at which the control becomes active (value limit: 0-10 ° C). This value must always be greater than the switch-off value.
<br><br>
<b>switch-off value: </b> is the value at which the control becomes inactive (value: 0-10 ° C). The values may not be the same in order to avoid a wild switching on and off.
<br><br>
<b>recommendation:</b> check the stored values in the logfile!
<br><br>
<b>attention: </b> use only positive integers!
<br><br> <br><br>
<b>setpoint temperature:</b> The desired temperature is set here. the minimum value is 0 ° C, the maximum + 25 ° C. 
<br> For technical reasons, not all values can be approached in any operating mode. the circulating air is always active during the cooling or heating phases.
<br><br>
<b>example of cooling:</b>
</b><i>setpoint temperature: 12°C; switch-on value: 3°C; switch-off value: 1°C</i>
<br>switch-on temperature = setpoint temperature + switch-on value --> 12°C + 3°C = 15°C
<br>switch-off temperature = setpoint temperature + switch-off value --> 12°C + 1°C = 13°C
<br>So, if 15 degrees are exceeded, the pi-ager cools down to 13 ° C and then switches off to avoid excessive cooling. 
<br>Tthe entire behavior is different from pi-ager to pi-ager and therefore to be determined individually.
<br><br>
<b>example of heating:</b>
</b><i>setpoint temperature: 22°C; switch-on value: 3°C; switch-off value 1°C</i>
<br>switch-on temperature = setpoint temperature - switch-on value --> 22°C - 3°C = 19°C
<br>switch-off temperature = setpoint temperature - switch-off value --> 22°C - 1°C = 21°C
<br>So, if the temperature drops below 19 degrees, the pi-ager heats up to 21 ° C and then switches off to avoid excessive heating.
<br>The entire behavior is different from pi-ager to pi-ager and therefore to be determined individually.
<br><br>
<b>automatic mode:</b> in every automatic mode, the temperature is fully automatically controlled. 
first, the current temperature is determined. Then decide which method (cooling or heating) is suitable to reach the setpoint temperature set. this also means that the switching values of the hysteresis must not be too close together. Otherwise, cooling and heating could be switched on and off alternately.
<br><br>
<b>example of automatic:</b> setpoint temperature: 15°C; switch-on value: 5°C; switch-off value 3°C
<br>1st case: sensor temperature >= (setpoint temperature + switch-on value [=20°C]) = cooling on
<br>2st case: sensor temperature <= (setpoint temperature + switch-off value [=18°C]) = cooling off
<br>3st case: sensor temperature >= (setpoint temperature - switch-on value [=10°C]) = heating on
<br>4st case: sensor temperature <= (setpoint temperature - switch-off value [=12°C]) = heating off
<br><br>
<b>recommendation:</b> check the stored values in the logfile!
<br><br>
<b>attention:</b> use only positive integers!
<br><br> <br><br>
<b><u>Analog sensors: </u></b>
<br>A 4-channel AD converter was implemented on the Pi-Ager board and integrated into the software. With this it is now possible to operate various other analog sensors on the system. (especially NTC temperature sensors)
<br>
<br>If sensor channels are not used, please select ------.
<br><br>
<b>Temperature sensors: </b> For example, if you want to monitor the temperature in the meat at different points, this is possible with the appropriate meat temperature sensors. Due to the lower temperatures, the 100K sensors are recommended because of the better resolution. However, the 1000kOhm NTC sensors also work without problems. 
<br>Nearly all temperature sensors can be used, which are also used in the Wlanthermo project.
<br><br>
<b>Current sensor: </b> It is possible to connect a current sensor to channel 4. So it is possible to monitor the current of the system.
<br> Supported sensor type: LEM HO 6-P/SP33 (It is important to use the version with the 3.3V power supply).
<br> For correct values to be displayed, 3 windings (turns) must be passed through the sensor. 
<br><br>
<br><b>Attention! </b> It is necessary to count the turns that are passed through the feedthrough of the sensor. At this point you can easily make a mistake...
<br><br>
<b>Annotation: </b>Up to board version 2.2 all 4 inputs were prepared for NTC sensors and equipped with 2.5 mm stereo jack sockets. From board version 2.3 on, channel 4 has been prepared for connection of a current sensor (3.5 mm stereo jack socket) and can be used immediately. All boards with version 2.2 and smaller can be modified to connect a current sensor. But you have to use a 2.5 mm jack plug in this case.
<br><br> <br><br>
<b>period: </b> This is used to set the pause time, which waits until the UV light is switched on again. If the value is 0 (= no pause), the UV light is permanently switched on. The maximum value is 1440min.
<br><br>
<b>duration: </b> This sets UV light time during which the light is switched on. At 0, the UV light timer function is switched off. The maximum value is 1440min.
<br><br>
<b>timestamp: </b> As an alternative to the cycle, a fixed time can be set here at which the UV light is switched on for the set duration.
<br><br>
<b>note: </b> For security reasons, you can manually switch off the UV light permanently via a switch on the admin page.  In this case, the timer can no longer turn on the UV light.
<br><br>
<b>attention: </b> period=0 und duration=0 is not useful and not allowed.
<br><br> 