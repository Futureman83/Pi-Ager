<?php
#gpio
$gpio_cooling_compressor = 4;
$gpio_heater = 3;
$gpio_humidifier = 18;
$gpio_circulating_air = 24;
$gpio_exhausting_air = 23;
$gpio_uv_light = 25;
$gpio_light = 8;
$gpio_dehumidifier = 7;
$gpio_voltage = 26;
$gpio_battery = 11;
$gpio_digital_switch = 22;
#------------------------ tables names
$config_settings_table = 'config';
$status_heater_table = 'heater_status';
$status_exhaust_air_table = 'exhaust_air_status';
$status_cooling_compressor_table = 'cooling_compressor_status';
$status_circulating_air_table = 'circulating_air_status';
$status_uv_table = 'uv_status';
$status_light_table = 'light_status';
$status_humidifier_table = 'humidifier_status';
$status_dehumidifier_table = 'dehumidifier_status';
$current_values_table = 'current_values';
$agingtables_table = 'agingtables';
$settings_scale1_table = 'scale1_settings';
$settings_scale2_table = 'scale2_settings';
$debug_table = 'debug';
$agingtable_salami_table = 'agingtable_salami';
$agingtable_dryaging1_table = 'agingtable_dryaging1';
$agingtable_dryaging2_table = 'agingtable_dryaging1';
$system_table = 'system';
$meat_sensortypes = 'meat_sensortypes';
$backup_table = 'config_nfs_backup';
$telegram_table = 'config_telegram';
$pushover_table = 'config_pushover';
$mailserver_table = 'config_email_server';
$email_recipients_table = 'config_email_recipient';
$alarm_table = 'config_alarm';
$messenger_table = 'config_messenger_exception';
$messenger_event_table = 'config_messenger_event';
$all_sensors_table = 'all_sensors';
$all_scales_table = 'all_scales';
$nextion_table = 'nextion';
$atc_mi_thermometer_mac_table = 'atc_mi_thermometer_mac';
$atc_mi_thermometer_data_table = 'atc_mi_thermometer_data';
$defrost_table = 'config_defrost';
$config_current_check_table = 'config_current_check';

#----------------------------table keys;
$switch_on_cooling_compressor_key = 'switch_on_cooling_compressor';
$switch_off_cooling_compressor_key = 'switch_off_cooling_compressor';
$switch_on_humidifier_key = 'switch_on_humidifier';
$switch_off_humidifier_key = 'switch_off_humidifier';
$delay_humidify_key = 'delay_humidify';
$referenceunit_key = 'referenceunit';
$sensortype_key = 'sensortype';
$sensorsecondtype_key = 'secondsensortype';
$language_key = 'language';
$switch_on_light_hour_key = 'switch_on_light_hour';
$switch_on_light_minute_key = 'switch_on_light_minute';
$light_duration_key = 'light_duration';
$light_period_key = 'light_period';
$light_modus_key = 'light_modus';
$switch_on_uv_hour_key = 'switch_on_uv_hour';
$switch_on_uv_minute_key = 'switch_on_uv_minute';
$uv_duration_key = 'uv_duration';
$uv_period_key = 'uv_period';
$uv_modus_key = 'uv_modus';
$uv_check_key = 'uv_check';
$dehumidifier_modus_key = 'dehumidifier_modus';
$circulation_air_period_key = 'circulation_air_period';
$setpoint_temperature_key = 'setpoint_temperature';
$sensor_temperature_key = 'sensor_temperature';
$sensor_humidity_key = 'sensor_humidity';
$exhaust_air_duration_key = 'exhaust_air_duration';
$modus_key = 'modus';
$setpoint_humidity_key = 'setpoint_humidity';
$exhaust_air_period_key = 'exhaust_air_period';
$circulation_air_duration_key = 'circulation_air_duration';
$agingtable_key = 'agingtable';
$status_exhaust_air_key = 'status_exhaust_air';
$status_circulating_air_key = 'status_circulating_air';
$status_heater_key = 'status_heater';
$status_cooling_compressor_key = 'status_cooling_compressor';
$scale1_key = 'scale1';
$scale2_key = 'scale2';
$calibrate_scale1_key = 'calibrate_scale1';
$calibrate_scale2_key = 'calibrate_scale2';
$calibrate_weight_key = 'calibrate_weight';
$status_piager_key = 'status_piager';
$status_agingtable_key = 'status_agingtable';
$status_scale1_key = 'status_scale1';
$status_scale2_key = 'status_scale2';
$status_scale1_tara_key = 'status_tara_scale1';
$status_scale2_tara_key = 'status_tara_scale2';
$loglevel_file_key = 'loglevel_file';
$loglevel_console_key = 'loglevel_console';
$agingtable_period_key = 'agingtable_period';
$agingtable_period_starttime_key = 'agintable_period_starttime';
$measuring_interval_debug_key = 'measuring_interval_debug';
$agingtable_days_in_seconds_debug_key = 'agingtable_days_in_seconds_debug';
$status_light_manual_key = 'status_light_manual';
$failure_humidity_delta_key = 'failure_humidity_delta';
$failure_temperature_delta_key = 'failure_temperature_delta';
$samples_key = 'samples';
$spikes_key = 'spikes';
$sleep_key = 'sleep';
$gain_key = 'gain';
$offset_key = 'offset';
$bits_to_read_key = 'bits_to_read';
$scale_measuring_interval_key = 'measuring_interval';
$measuring_duration_key = 'measuring_duration';
$saving_period_key = 'saving_period';
$pi_revision_key = 'pi_revision';
$pi_ager_version_key = 'pi_ager_version';
$status_uv_manual_key = 'status_uv_manual';
$save_temperature_humidity_loops_key = 'save_temperature_humidity_loops';
$sensorbus_key = 'sensorbus';
$temperature_meat1_key = 'temperature_meat1';
$temperature_meat2_key = 'temperature_meat2';
$temperature_meat3_key = 'temperature_meat3';
$temperature_meat4_key = 'temperature_meat4';
$meat1_sensortype_key = 'meat1_sensortype';
$meat2_sensortype_key = 'meat2_sensortype';
$meat3_sensortype_key = 'meat3_sensortype';
$meat4_sensortype_key = 'meat4_sensortype';
$customtime_for_diagrams_key = 'customtime_for_diagrams';
$agingtable_startday_key = 'agingtable_startday';
$agingtable_startperiod_key = 'agingtable_startperiod';
$sensor_dewpoint_key = 'sensor_dewpoint';
$sensor_humidity_abs_key = 'sensor_humidity_abs';
$sensor_extern_temperature_key = 'sensor_extern_temperature';
$sensor_extern_humidity_key = 'sensor_extern_humidity';
$sensor_extern_dewpoint_key = 'sensor_extern_dewpoint';
$sensor_extern_humidity_abs_key = 'sensor_extern_humidity_abs';
$agingtable_period_day_key = 'agingtable_period_day';
$aging_thread_alive_key = 'aging_thread_alive';
$scale1_thread_alive_key = 'scale1_thread_alive';
$scale2_thread_alive_key = 'scale2_thread_alive';
$status_light_key = 'status_light';
$status_uv_key = 'status_uv';
$status_humidifier_key = 'status_humidifier';
$status_dehumidifier_key = 'status_dehumidifier';
$tft_display_type_key = 'tft_display_type';
$internal_temperature_low_limit_key = 'internal_temperature_low_limit';
$internal_temperature_high_limit_key = 'internal_temperature_high_limit';
$internal_temperature_hysteresis_key = 'internal_temperature_hysteresis';
$shutdown_on_batlow_key = 'shutdown_on_batlow';
$diagram_modus_key = 'diagram_modus';
$delay_cooler_key = 'delay_cooler';
$dewpoint_check_key = 'dewpoint_check';
$status_humidity_check_key = 'status_humidity_check';
$humidity_check_hysteresis_key = 'humidity_check_hysteresis';
$mi_data_key = 'mi_data';
$mi_mac_last3bytes_key = 'mi_mac_last3bytes';
$MiSensor_battery_key = 'MiSensor_battery';
$switch_control_uv_light_key = 'switch_control_uv_light';
$switch_control_light_key = 'switch_control_light';
$status_defrost_key = 'status_defrost';

#-----------------------------table fields;
$key_field = 'key';
$value_field = 'value';
$last_change_field = 'last_change';
$agingtable_name_field = 'name';
$id_field = 'id';
$agingtable_modus_field = 'modus';
$agingtable_setpoint_humidity_field = 'setpoint_humidity';
$agingtable_setpoint_temperature_field = 'setpoint_temperature';
$agingtable_circulation_air_duration_field = 'circulation_air_duration';
$agingtable_circulation_air_period_field = 'circulation_air_period';
$agingtable_exhaust_air_duration_field = 'exhaust_air_duration';
$agingtable_exhaust_air_period_field = 'exhaust_air_period';
$agingtable_days_field = 'days';
$agingtable_comment_field = 'comment';
$meat_sensortypes_name_field = 'name';
$meat_sensortypes_a_field = 'a';
$meat_sensortypes_b_field = 'b';
$meat_sensortypes_c_field = 'c';
$meat_sensortypes_Rn_field = 'Rn';
$meat_sensortypes_Mode_field = 'Mode';
$meat_sensortypes_RefVoltage_field = 'RefVoltage';
$meat_sensortypes_Sensitivity_field = 'Sensitivity';
$meat_sensortypes_Turns_field = 'Turns';
$meat_sensortypes_nAverage_field = 'nAverage';
$backup_nfsvol_field = 'nfsvol';
$backup_subdir_field = 'subdir';
$backup_nfsmount_field = 'nfsmount';
$backup_path_field = 'backup_path';
$backup_number_of_backups_field = 'number_of_backups';
$backup_name_field = 'backup_name';
$backup_nfsopt_field = 'nfsopt';
$backup_active_field = 'active';
$telegram_id_field = 'id';
$telegram_bot_token_field = 'bot_token';
$telegram_bot_chat_id_field = 'bot_chatID';
$telegram_active_field = 'active';
$pushover_id_field = 'id';
$pushover_user_key_field = 'user_key';
$pushover_api_token_field = 'api_token';
$pushover_active_field = 'active';
$mailserver_id_field = 'id';
$mailserver_server_field = 'server';
$mailserver_user_field = 'user';
$mailserver_password_field = 'password';
$mailserver_starttls_field = 'starttls';
$mailserver_from_mail_field = 'from_mail';
$mailserver_port_field = 'port';
$e_mail_recipients_to_mail_field = 'to_mail';
$e_mail_recipients_active_field = 'active';
$e_mail_recipients_id_field = 'id';
$alarm_id_field = 'id';
$alarm_alarm_field = 'alarm';
$alarm_replication_field = 'replication';
$alarm_sleep_field = 'sleep';
$alarm_high_time_field = 'high_time';
$alarm_low_time_field = 'low_time';
$alarm_waveform_field = 'waveform';
$alarm_frequency_field = 'frequency';
$messenger_id_field = 'id';
$messenger_exception_field = 'exception';
$messenger_e_mail_field = 'e-mail';
$messenger_pushover_field = 'pushover';
$messenger_telegram_field = 'telegram';
$messenger_alarm_field = 'alarm';
$messenger_raise_exception_field = 'raise_exception';
$messenger_active_field = 'active';
$event_id_field = 'id';
$event_event_field = 'event';
$event_e_mail_field = 'e-mail';
$event_pushover_field = 'pushover';
$event_telegram_field = 'telegram';
$event_alarm_field = 'alarm';
$event_eventtext_field = 'event_text';
$event_active_field = 'active';
$tempint_field = 'tempint';
$tempext_field = 'tempext';
$humint_field = 'humint';
$humext_field = 'humext';
$dewint_field = 'dewint';
$dewext_field = 'dewext';
$humintabs_field = 'humintabs';
$humextabs_field = 'humextabs';
$ntc1_field = 'ntc1';
$ntc2_field = 'ntc2';
$ntc3_field = 'ntc3';
$ntc4_field = 'ntc4';
$scale1_field = 'scale1';
$scale2_field = 'scale2';
$progress_field = 'progress';
$status_field = 'status';
$defrost_active_field = 'active';
$defrost_temperature_field = 'temperature';
$defrost_cycle_hours_field = 'cycle_hours';
$current_check_active_field = 'current_check_active';
$current_threshold_field = 'current_threshold';
$repeat_event_cycle_field = 'repeat_event_cycle';

#-----------------------------Paths and urls
$thread_url = 'https://www.grillsportverein.de/forum/threads/pi-ager-reifeschranksteuerung-mittels-raspberry-pi.273805/';
$error_reporting_url = 'https://github.com/Tronje-the-Falconer/Pi-Ager/wiki/Error-reporting';
$faq_url =  'https://github.com/Tronje-the-Falconer/Pi-Ager/wiki/FAQ';
$sqlite_path = '/var/www/config/pi-ager.sqlite3';
$logfile_txt_file = '/var/www/logs/logfile.txt';
$pi_ager_log_file = '/var/www/logs/pi-ager.log';
$changelogfile = '/var/www/changelog.html';
#-----------------------------JSON Keys
$last_change_temperature_json_key = 'last_change_temperature';
$last_change_humidity_json_key = 'last_change_humidity';
$last_change_dewpoint_json_key = 'last_change_dewpoint';
$last_change_humidity__abs_json_key = 'last_change_humidity_abs';
$last_change_extern_temperature_json_key = 'last_change_extern_temperature';
$last_change_extern_humidity_json_key = 'last_change_extern_humidity';
$last_change_extern_dewpoint_json_key = 'last_change_extern_dewpoint';
$last_change_extern_humidity_abs_json_key = 'last_change_extern_humidity_abs';
$last_change_scale1_json_key = 'last_change_scale1';
$last_change_scale2_json_key = 'last_change_scale2';
$last_change_temperature_meat1_json_key = 'last_change_temperature_meat1';
$last_change_temperature_meat2_json_key = 'last_change_temperature_meat2';
$last_change_temperature_meat3_json_key = 'last_change_temperature_meat3';
$last_change_temperature_meat4_json_key = 'last_change_temperature_meat4';
$meat1_sensor_name_json_key = 'meat1_sensor_name';
$meat2_sensor_name_json_key = 'meat2_sensor_name';
$meat3_sensor_name_json_key = 'meat3_sensor_name';
$meat4_sensor_name_json_key = 'meat4_sensor_name';
$server_time_json_key = 'server_time';
?>
