                                <?php
                                include 'modules/write_config_db_logfile_txt.php';          // Speichert die eingestelle Configuration (Hysteresen, Sensortyp, GPIO's)
                                include 'modules/read_config_db.php';                       // Liest die Grundeinstellungen Sensortyp, Hysteresen, GPIO's)
                                ?>
                                <button class="art-button" type="button" onclick="setconfig_blockFunction()"><?php echo _('set general configuration values'); ?></button>
                                </br>
                                </br>
                                <div id="set_config" class="help_p">
                                    <form method="post" name="config">
                                        <div class="hg_container" >
                                            <b><?php echo strtoupper(_('attention! be carful what you do!')); ?></b>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------Temperatur-->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td rowspan="4" class="td_png_icon"><h3><?php echo _('temperature'); ?></h3><img src="images/icons/heating_cooling_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_temperature_config_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td><?php echo _('switch-on value'); ?>:</td>
                                                    <td><input name="switch_on_cooling_compressor_config" type="number" style="width: 30%;" min="-10" max="10" step="0.1" required value=<?php echo $switch_on_cooling_compressor; ?>>&nbsp;°C
                                                        <span style="font-size: xx-small;">
                                                            <?php 
                                                                if($modus == 0 || $modus == 1){
                                                                    echo '('._('on at')." ".($setpoint_temperature+$switch_on_cooling_compressor)." °C)";
                                                                }
                                                                elseif($modus == 2){
                                                                    echo '('._('on at')." ".($setpoint_temperature-$switch_on_cooling_compressor)." °C)";
                                                                }
                                                                else {
                                                                    echo _('see logs');
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('switch-off value').':'; ?></td>
                                                    <td><input name="switch_off_cooling_compressor_config" type="number" style="width: 30%;" min="-10" max="10" step="0.1" required value= <?php echo $switch_off_cooling_compressor; ?>>&nbsp;°C
                                                        <span style="font-size: xx-small">
                                                            <?php 
                                                                if($modus == 0 || $modus == 1){
                                                                    echo '('._('off at').' '.($setpoint_temperature+$switch_off_cooling_compressor).' °C)';
                                                                }
                                                                elseif($modus == 2){
                                                                    echo '('._('off at').' '.($setpoint_temperature-$switch_off_cooling_compressor).' °C)';
                                                                }
                                                                else {
                                                                    echo _('see logs');
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('delay'); ?>:</td>
                                                    <td><input name="delay_cooler_config" type="number" style="width: 30%;" min="30" max="120" step="1" required value=<?php echo $delay_cooler; ?>>&nbsp;<?php echo _('seconds'); ?><span style="font-size: xx-small"> (30 <?php echo _('to'); ?> 120)</span></td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_temperature_config_blockFunction() {
                                                    document.getElementById('help_temperature_config').style.display = 'block';
                                                }
                                                function help_temperature_config_noneFunction() {
                                                    document.getElementById('help_temperature_config').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_temperature_config" class="help_p">
                                                <?php echo _('helptext_temperature_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_temperature_config_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------Luftfeuchte-->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td rowspan="4" class="td_png_icon"><h3><?php echo _('humidity'); ?></h3><img src="images/icons/humidification_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_humidify_config_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td><?php echo _('switch-on value').':'; ?></td>
                                                    <td><input name="switch_on_humidifier_config" type="number" style="width: 30%;" min="-30" max="30" required value=<?php echo $switch_on_humidifier; ?>>&nbsp;%<span style="font-size: xx-small">
                                                    <?php 
                                                                if($modus == 0 || $modus == 1 || $modus == 2){
                                                                    echo '('._('on at'). ' '.($setpoint_humidity-$switch_on_humidifier)."%)";
                                                                }
                                                                else {
                                                                    echo _('see logs');
                                                                }
                                                    ?>
                                                        </span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('switch-off value').':'; ?></td>
                                                    <td><input name="switch_off_humidifier_config" type="number" style="width: 30%;" min="-30" max="30" required value=<?php echo $switch_off_humidifier; ?>>&nbsp;%<span style="font-size: xx-small">
                                                    <?php 
                                                                if($modus == 0 || $modus == 1 || $modus == 2){
                                                                    echo '('._('off at'). ' '.($setpoint_humidity-$switch_off_humidifier)."%)";
                                                                }
                                                                else {
                                                                    echo _('see logs');
                                                                }
                                                    ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('delay'); ?>:</td>
                                                    <td><input name="delay_humidify_config" type="number" style="width: 30%;" min="0" max="60" required value=<?php echo $delay_humidify; ?>>&nbsp;<?php echo _('minutes'); ?><span style="font-size: xx-small"> (0 <?php echo _('to'); ?> 60)</span></td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_humidify_config_blockFunction() {
                                                    document.getElementById('help_humidify_config').style.display = 'block';
                                                }
                                                function help_humidify_config_noneFunction() {
                                                    document.getElementById('help_humidify_config').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_humidify_config" class="help_p">
                                                <?php echo _('helptext_humidify_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_humidify_config_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------dehumidify-->
                                            <?php
                                                if ($dewpoint_check == 1) {
                                                    $dewpoint_check_config_active = 'checked';
                                                }
                                                else {
                                                    $dewpoint_check_config_active = '';
                                                }
                                                if ($uv_check == 1) {
                                                    $uv_check_config_active = 'checked';
                                                }
                                                else {
                                                    $uv_check_config_active = '';
                                                }                                                
                                            ?>
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td class="td_png_icon"><h3><?php echo _('dehumidify'); ?></h3><img src="images/icons/dehumidification_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_dehumidifier_blockFunction()"><?php echo _('help'); ?></button>
                                                    </td>
                                                    <td style=" text-align: left; padding-left: 20px;">
                                                        <input type="radio" name="dehumidifier_modus_config" value="1" <?php echo $checked_dehumidify_1; ?>/><label> <?php echo _('only exhaust'); ?></label><br>
                                                        <input type="radio" name="dehumidifier_modus_config" value="2" <?php echo $checked_dehumidify_2; ?>/><label> <?php echo _('exhaust & dehumidifier'); ?></label><br>
                                                        <input type="radio" name="dehumidifier_modus_config" value="3" <?php echo $checked_dehumidify_3; ?>/><label> <?php echo _('only dehumidifier'); ?></label><br><br>
                                                        <?php
                                                            # $bus = intval(get_table_value($config_settings_table, $sensorbus_key));
                                                            if ($sensorsecondtype != 0){        //($bus == 0 and $sensorsecondtype != 0) {
                                                                echo _('abs. humidity check aktive') . ': ';
                                                                echo '<input type="hidden" name="dewpoint_check_config" value="0"/>';
                                                                echo '<input type="checkbox" name="dewpoint_check_config" value="1" ';
                                                                echo $dewpoint_check_config_active . '/>';
                                                            }
                                                            else {
                                                                echo '<input type="hidden" name="dewpoint_check_config" value="0"/>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_dehumidifier_blockFunction() {
                                                    document.getElementById('help_dehumidifier').style.display = 'block';
                                                }
                                                function help_dehumidifier_noneFunction() {
                                                    document.getElementById('help_dehumidifier').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_dehumidifier" class="help_p">
                                                <?php echo _('helptext_dehumidifier_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_dehumidifier_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------uv-->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td rowspan="5" class="td_png_icon"><h3><?php echo _('uv'); ?></h3><img src="images/icons/uv-light_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_uv_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td colspan="2" style="text-align: left; padding-left: 20px;">
                                                        <input type="radio" name="uv_modus_config" value="1" <?php echo $checked_uv_1; ?>/><label> <?php echo _('ON/OFF duration'); ?></label><br>
                                                        <input type="radio" name="uv_modus_config" value="2" <?php echo $checked_uv_2; ?>/><label> <?php echo _('ON duration & timestamp'); ?></label><br>
                                                        <input type="radio" name="uv_modus_config" value="0" <?php echo $checked_uv_0; ?>/><label> <?php echo _('OFF'); ?></label><br>
                                                        <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('OFF duration').':'; ?></td>
                                                    <td><input name="uv_period_config" type="number" style="width: 30%;" min="0" max="1440" required value=<?php echo $uv_period; ?>>&nbsp;<?php echo _('minutes'); ?><span style="font-size: xx-small"> (0 <?php echo _('to'); ?> 1440)</span>
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('ON duration'); ?>:</td>
                                                    <td><input name="uv_duration_config" type="number" style="width: 30%;" min="0" max="1440" required value=<?php echo $uv_duration; ?>>&nbsp;<?php echo _('minutes'); ?><span style="font-size: xx-small"> (0 <?php echo _('to'); ?> 1440)</span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('timestamp'); ?>:</td>
                                                    <td><input name="switch_on_uv_hour_config" type="number" style="width: 30%;" min="0" max="23" required value=<?php echo $switch_on_uv_hour; ?>> : <input name="switch_on_uv_minute_config" type="number" style="width: 30%;" min="0" max="59" value=<?php echo $switch_on_uv_minute; ?>>&nbsp;<?php echo _("o'clock"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('activate circulating air') . ': ';?></td>
                                                    <td>
                                                        <input type="hidden" name="uv_check_config" value="0" />
                                                        <input type="checkbox" name="uv_check_config" value="1" <?php echo $uv_check_config_active; ?> />
                                                    </td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_uv_blockFunction() {
                                                    document.getElementById('help_uv').style.display = 'block';
                                                }
                                                function help_uv_noneFunction() {
                                                    document.getElementById('help_uv').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_uv" class="help_p">
                                                <?php echo _('helptext_uv_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_uv_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------light-->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td rowspan="4" class="td_png_icon"><h3><?php echo _('light'); ?></h3><img src="images/icons/light_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_light_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td colspan="2" style="text-align: left; padding-left: 20px;">
                                                        <input type="radio" name="light_modus_config" value="1" <?php echo $checked_light_1; ?>/><label> <?php echo _('ON/OFF duration'); ?></label><br>
                                                        <input type="radio" name="light_modus_config" value="2" <?php echo $checked_light_2; ?>/><label> <?php echo _('ON duration & timestamp'); ?></label><br>
                                                        <input type="radio" name="light_modus_config" value="0" <?php echo $checked_light_0; ?>/><label> <?php echo _('OFF'); ?></label><br>
                                                        <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('OFF duration').':'; ?></td>
                                                    <td><input name="light_period_config" type="number" style="width: 30%;" min="0" max="1440" required value=<?php echo $light_period; ?>>&nbsp;<?php echo _('minutes'); ?><span style="font-size: xx-small"> (0 <?php echo _('to'); ?> 1440)</span>
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('ON duration'); ?>:</td>
                                                    <td><input name="light_duration_config" type="number" style="width: 30%;" min="0" max="1440" required value=<?php echo $light_duration; ?>>&nbsp;<?php echo _('minutes'); ?><span style="font-size: xx-small"> (0 <?php echo _('to'); ?> 1440)</span></td>
                                                </tr>
                                                                                                <tr>
                                                    <td><?php echo _('timestamp'); ?>:</td>
                                                    <td><input name="switch_on_light_hour_config" type="number" style="width: 30%;" min="0" max="23" required value=<?php echo $switch_on_light_hour; ?>> : <input name="switch_on_light_minute_config" type="number" style="width: 30%;" min="0" max="59" value=<?php echo $switch_on_light_minute; ?>>&nbsp;<?php echo _("o'clock"); ?></td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_light_blockFunction() {
                                                    document.getElementById('help_light').style.display = 'block';
                                                }
                                                function help_light_noneFunction() {
                                                    document.getElementById('help_light').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_light" class="help_p">
                                                <?php echo _('helptext_light_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_light_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------temperature limits to generate events -->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <tr>
                                                    <td rowspan="4" class="td_png_icon"><h3><?php echo _('internal temperature limits'); ?></h3><img src="images/icons/heating_cooling_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_temperature_event_config_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td><?php echo _('low temperature limit'); ?>:</td>
                                                    <td><input name="internal_temperature_low_limit_config" type="number" style="width: 30%;" min="-11" max="70" required value=<?php echo $internal_temperature_low_limit; ?>>&nbsp;°C<span style="font-size: xx-small"> (-11 <?php echo _('to'); ?> 70)</span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('high temperature limit').':'; ?></td>
                                                    <td><input name="internal_temperature_high_limit_config" type="number" style="width: 30%;" min="-11" max="70" required value= <?php echo $internal_temperature_high_limit; ?>>&nbsp;°C<span style="font-size: xx-small"> (-11 <?php echo _('to'); ?> 70)</span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo _('hysteresis').':'; ?></td>
                                                    <td><input name="internal_temperature_hysteresis_config" type="number" style="width: 30%;" min="1" max="10" required value= <?php echo $internal_temperature_hysteresis; ?>>&nbsp;°C<span style="font-size: xx-small"> (1 <?php echo _('to'); ?> 10)</span></td>
                                                </tr>                                                
                                                
                                            </table>
                                            <script>
                                                function help_temperature_event_config_blockFunction() {
                                                    document.getElementById('help_temperature_event_config').style.display = 'block';
                                                }
                                                function help_temperature_event_config_noneFunction() {
                                                    document.getElementById('help_temperature_event_config').style.display = 'none';
                                                }
                                            </script>
                                            <p id="help_temperature_event_config" class="help_p">
                                                <?php echo _('helptext_temperature_event_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_temperature_event_config_noneFunction()"><?php echo _('close'); ?></button>
                                            </p>
                                            <hr>
                                            <!----------------------------------------------------------------------------------------shutdown on battery low -->
                                            <table style="width: 100%;table-layout: fixed;">
                                                <?php
                                                    if ($shutdown_on_batlow == 1) {
                                                        $checked_shutdown_on_batlow_true = 'checked';
                                                    }
                                                    else {
                                                        $checked_shutdown_on_batlow_true = '';
                                                    }
                                                ?>
                                                <tr>
                                                    <td rowspan="3" class="td_png_icon"><h3><?php echo _('UPS battery'); ?></h3><img src="images/icons/battery_42x42.png" alt=""><br><button class="art-button" type="button" onclick="help_shutdown_on_batlow_config_blockFunction()"><?php echo _('help'); ?></button></td>
                                                    <td columnspan="2" style="width: 100%;"><?php echo _('shutdown on battery low'); ?>:
                                                        <input type="hidden" name="shutdown_on_batlow_config" value="0"/>
                                                        <input type="checkbox" name="shutdown_on_batlow_config" value="1" <?php echo $checked_shutdown_on_batlow_true; ?>/>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <script>
                                                function help_shutdown_on_batlow_config_blockFunction() {
                                                    document.getElementById('help_shutdown_on_batlow_config').style.display = 'block';
                                                }
                                                function help_shutdown_on_batlow_config__noneFunction() {
                                                    document.getElementById('help_shutdown_on_batlow_config').style.display = 'none';
                                                }
                                            </script> 
                                            <p id="help_shutdown_on_batlow_config" class="help_p">
                                                <?php echo _('helptext_shutdown_on_batlow_config');
                                                      echo '<br><br>'; ?>
                                                <button class="art-button" type="button" onclick="help_shutdown_on_batlow_config__noneFunction()"><?php echo _('close'); ?></button>
                                            </p>                                            
                                            <br>
                                            <br>
                                            <table style="width: 100%; align: center;">
                                                <tr>
                                                    <td style="width: 75%; text-align: right;">&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td style="text-align: right;"><button class="art-button" name="config_form_submit" type="submit" value="config_form_submit" onclick="return confirm('<?php echo _('save'); echo ' '; echo _('general configuration'); ?>?')"><?php echo _('save'); ?></button></td>
                                                    <td style="text-align: left;">
                                                        <button class="art-button" type="button" onclick="setconfig_noneFunction()"><?php echo _('hide'); ?></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <script>
                                    function setconfig_blockFunction() {
                                        document.getElementById('set_config').style.display = 'block';
                                    }
                                    function setconfig_noneFunction() {
                                        document.getElementById('set_config').style.display = 'none';
                                    }
                                </script>
