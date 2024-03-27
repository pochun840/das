<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/setting.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/fontawesome5.12.1.css" type="text/css">

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<style type="text/css">
    @font-face
    {
      font-family: 'fa-solid-900';
      src: url('<?php echo URLROOT; ?>font/fa-solid-900.woff2') format('truetype');
    }
    .t1{font-size: 17px; margin: 5px 0px;display: flex; align-items: center;}
    .t2{font-size: 17px; margin: 5px 0px;}
    .rr{margin-bottom: 0.25rem;margin-top: 0.25rem;}

</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                    <h3><?php echo $text['setting']; ?></h3>
                </td>
                <td>
                    <button id="home" class="w3-btn w3-round-large" style="height:50px;padding: 0" onclick="window.location.href='./?url=Dashboards'"> <img src="../public/img/btn_home.png"></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content ">
        <div class="center-content">
            <div class="w3-center col-ms-3 pt-2">
                <button id="bnt1" name="Controller_Display" class="button button3 active" onclick="OpenButton('Controller')"><?php echo $text['controller_setting']; ?></button>
                <button id="bnt2" name="System_Display" class="button button3" onclick="OpenButton('System')"><?php echo $text['system_setting']; ?></button>
                <button id="bnt3" name="Barcode_Display" class="button button3" onclick="OpenButton('Barcode')"><?php echo $text['system_barcode_setting']; ?></button>
                <button id="bnt4" name="Connect_Display" class="button button3" onclick="OpenButton('Connect')" <?php if($_SESSION['privilege'] != 'admin'){echo "style=\"display:none\" ";} ?>><?php echo $text['system_connect_setting']; ?></button>
                <button id="bnt5" name="iDas_Display" class="button button3" onclick="OpenButton('Update')">iDAS</button>
            </div>

            <div id="Controller_Setting" style="padding: 10px;overflow-x: hidden;">
                <div class="container div-setting">
                    <h4 style="margin: 5px 5px 10px; padding: 5px;"><b><?php echo $text['controller_setting']; ?></b></h4>
                    <form id="con_setting" onsubmit="control_setting();return false;" method="get">
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_id']; ?> :</div>
                            <div class="col-6 t2" style="">
                                <input id="control_id" name="control_id" style="height: 32px" type="number" max=255 min=1 maxlength="3" value="<?php echo $data['Controller_Info']['device_id']; ?>" class="form-control"  required>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_name']; ?> :</div>
                            <div class="col-6 t2" style="">
                                <input id="control_name" name="control_name" style="height: 32px" maxlength="14" type="text" value="<?php echo $data['Controller_Info']['device_name']; ?>" class="form-control"  required>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_unit']; ?> :</div>
                            <div class="col-6 t2" style="">
                                <select class="form-select" id="torque_unit" name="torque_unit">
                                    <option value="0"><?php echo $text['unit_status_0']; ?></option>
                                    <option value="1"><?php echo $text['unit_status_1']; ?></option>
                                    <option value="2"><?php echo $text['unit_status_2']; ?></option>
                                    <option value="3"><?php echo $text['unit_status_3']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_language']; ?> :</div>
                            <div class="col-6 t2" style="">
                                <select class="form-select" id="select_language" name="select_language">
                                    <option value="0">English</option>
                                    <option value="1">繁體中文</option>
                                    <option value="2">简体中文</option>
                                </select>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_batch']; ?> :</div>
                            <div class="col-6 t2 row" style="">
                                <div class="form-check form-check-inline col-5">
                                    <input class="form-check-input" type="radio" name="batch_mode_option" id="batch_mode_dec" value="0" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="batch_mode_dec"><?php echo $text['system_dec']; ?></label>
                                </div>
                                <div class="form-check col-5">
                                    <input class="form-check-input" type="radio" name="batch_mode_option" id="batch_mode_inc" value="1" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="batch_mode_inc"><?php echo $text['system_inc']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_buzzer']; ?> :</div>
                            <div class="col-6 t2 row" style="">
                                <div class="form-check form-check-inline col-5">
                                    <input class="form-check-input" type="radio" name="buzzer_mode_option" id="buzzer_mode_on" value="0" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="buzzer_mode_on"><?php echo $text['switch_on']; ?></label>
                                </div>
                                <div class="form-check col-5">
                                    <input class="form-check-input" type="radio" name="buzzer_mode_option" id="buzzer_mode_off" value="1" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="buzzer_mode_off"><?php echo $text['switch_off']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['system_blackout']; ?> :</div>
                            <div class="col-6 t2 row" style="">
                                <div class="form-check form-check-inline col-5">
                                    <input class="form-check-input" type="radio" name="blackout_recovery_option" id="blackout_recovery_on" value="0" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="blackout_recovery_on"><?php echo $text['switch_on']; ?></label>
                                </div>
                                <div class="form-check col-5 ">
                                    <input class="form-check-input" type="radio" name="blackout_recovery_option" id="blackout_recovery_off" value="1" style="zoom:1; vertical-align: middle;margin-top: 0.5rem;">
                                    <label class="rr" for="blackout_recovery_off"><?php echo $text['switch_off']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <label class="col-5 t1"><?php echo $text['system_diskfull_warning']; ?> :</label>
                            <div class="col-6 t2">
                                <input  style="font-size: 14px; height: 32px; margin-top: 4px" type="number" min="50" max="95" value="<?php echo $data['Controller_Info']['device_diskfullwarning']; ?>" class="form-control" id="Diskfull_Warning" name="Diskfull_Warning" required>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <label class="col-5 t1" style=""><?php echo $text['system_torque_filter']; ?> :</label>
                            <div class="col-6 t2" style="">
                                <input style="font-size: 14px; height: 32px; margin-top: 4px" type="number" step="any" value="<?php echo $data['Controller_Info']['device_torque_filter']; ?>" class="form-control" id="Torque_Filter" name="Torque_Filter" required>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-5 t1" style=""><?php echo $text['sample_rate']; ?> :</div>
                            <div class="col-6 t2" style="">
                                <select class="form-select" id="sample_rate" name="sample_rate">
                                    <option value="0">0.5 (ms)</option>
                                    <option value="1">1 (ms)</option>
                                    <option value="2">2 (ms)</option>
                                </select>
                            </div>
                        </div>
                        <div style="text-align: center;margin-top: 10px; margin-bottom: 10px">
                            <input class="all-btn w3-submit w3-border w3-round-large" type="submit" value="<?php echo $text['save']; ?>">
                        </div>
                    </form>
                </div>
            </div>


            <div id="System_Setting" style="padding: 10px; overflow-x: hidden; display: none;">
                <div class="container div-setting">
                    <h4 style="margin: 0px 5px 10px; padding: 0px;"><b><?php echo $text['system_setting']; ?></b></h4>
                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_password']; ?></div>
                        <div class="col t2">
                            <form id="edit_password" onsubmit="set_password();return false;" method="get">
                                <input type="password" id="new_password"  placeholder="<?php echo $text['system_new_password']; ?>" size="18" maxlength="10" required class="w3-submit w3-border" style="font-size: 14px; height: 32px; margin-bottom:2px" oninput="value=value.replace(/[^\d]/g,'')">
                                <input type="password" id="comfirm_password"  placeholder="<?php echo $text['system_confirm_password']; ?>" size="18" maxlength="10" required class="w3-submit w3-border" style="font-size: 14px; height: 32px;  margin-bottom:2px" oninput="value=value.replace(/[^\d]/g,'')">
                                <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right">
                            </form>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_sys_date']; ?> (UTC)</div>
                        <div class="col t2">
                            <form onsubmit="change_datetime();return false;">
                                <span id="currentSystemTime"></span>
                                <input type="datetime-local" id="newTime" value="" size="25" required class="w3-submit w3-border" style="margin: 0px 0px 5px; height: 32px">
                                <!-- 使用按钮来触发日期时间选择器 -->
                                <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right">
                            </form>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_export_config']; ?></div>
                        <div class="col t2">
                            <button onclick="Export_SystemConfig();" class="all-btn w3-button w3-border w3-round-large" style="float: right"><?php echo $text['system_export_config']; ?></button>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_import_config']; ?></div>
                        <div class="col-7 t2">
                            <input type="file" id="import-file-uploader" data-target="import-file-uploader" accept=".cfg" style="height: 35px;width: 50%;display: inline-block;" class="form-control">
                        </div>
                        <div class="col t2">
                            <button onclick="Import_SystemConfig();" class="all-btn w3-button w3-border w3-round-large"  style="float: right"><?php echo $text['system_import_config']; ?></button>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_firmware_update']; ?></div>
                        <div class="col-7 t2">
                            <input type="file" id="firmware-file-uploader" data-target="firmware-file-uploader" accept=".hex" style="height: 35px;width: 50%;display: inline-block;" class="form-control">
                        </div>
                        <div class="col t2">
                            <button onclick="Firmware_Update();" class="all-btn w3-button w3-border w3-round-large"  style="float: right"><?php echo $text['system_firmware_update']; ?></button>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_disc_space']; ?></div>
                        <div class="col progress t2" style="margin-top: 10px;padding-left: 0; margin-right: 10px">
                          <div id="disk_usage" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">25%</div>
                        </div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_delete_database']; ?></div>
                        <div  class="col t2" id="fileList" style="margin-top: 10px"></div>
                        <!-- 刪除按鈕 -->
                        <div class="col t2">
                            <button onclick="deleteSelectedFiles()" style="margin-top: 22px; float: right" class="all-btn w3-button w3-border w3-round-large" ><?php echo $text['delete_text']; ?></button>
                        </div>
                    </div>

                    <?php if (IDASMODE == 0) { ?>
                    <div class="row border-bottom">
                        <div class="col-4 t1"><?php echo $text['system_screwdriver_setting']; ?>(<?php echo $data['Tool_Info']['tool_type']; ?>)</div>
                        <div class="col t2">
                          <select id="tool_type" style="margin-top: 10px">
                            <option value="SGT-CS301">SGT-CS301</option>
                            <option value="SGT-CS302F">SGT-CS302F</option>
                            <option value="SGT-CS303">SGT-CS303</option>
                            <option value="SGT-CS503">SGT-CS503</option>
                            <option value="SGT-CS505">SGT-CS505</option>
                            <option value="SGT-CS507">SGT-CS507</option>
                            <option value="SGT-CS712">SGT-CS712</option>
                            <option value="SGT-CS718">SGT-CS718</option>
                            <option value="SGT-CS725">SGT-CS725</option>
                          </select>
                          <button onclick="ToolSelect();" class="all-btn w3-button w3-border w3-round-large" style="float: right"><?php echo $text['save']; ?></button>
                        </div>
                    </div>
                    <?php } ?>


                    <!-- <div class="row border-bottom">
                        <div class="col-5 t1"><?php echo $text['system_firmware_reset']; ?> (之後用modbus)</div>
                    </div> -->

                    <div class="row border-bottom" style="display: none;">
                        <div class="col-4 t1"><?php echo $text['system_db_exchange']; ?></div>
                        <div  class="col t2">
                            <button onclick="DB_sync('C2D')" class="all-btn w3-button w3-border w3-round-large"><?php echo $text['system_db_C2D']; ?></button>
                            <button onclick="DB_sync('D2C')" class="all-btn w3-button w3-border w3-round-large"><?php echo $text['system_db_D2C']; ?></button>
                        </div>
                    </div>

                    <div style="display:none;">
                        <input style="display:none;" id="t_unit" value="<?php echo $data['Controller_Info']['device_torque_unit']; ?>" disabled>
                        <input style="display:none;" id="s_lang" value="<?php echo $data['Controller_Info']['device_language']; ?>" disabled>
                        <input style="display:none;" id="batch_mode" value="<?php echo $data['Controller_Info']['device_batch_mode']; ?>" disabled>
                        <input style="display:none;" id="buzzer_mode" value="<?php echo $data['Controller_Info']['device_buzzer_mode']; ?>" disabled>
                        <input style="display:none;" id="device_memory" value="<?php echo $data['Controller_Info']['device_memory']; ?>" disabled>
                        <input style="display:none;" id="d_torque_filter" value="<?php echo $data['Controller_Info']['device_torque_filter']; ?>" disabled>
                        <input style="display:none;" id="sample_ra" value="<?php echo $data['Controller_Info']['device_datalog_frequency']; ?>" disabled>
                    </div>
                </div>
            </div>

            <!-- Barcode -->
            <div id="Barcode_Setting" style="padding: 10px; overflow-x: hidden; display: none">
                <div class="container div-setting">
                    <h4 style="margin: 5px 5px 10px; padding: 5px"><b><?php echo $text['system_barcode_setting']; ?></b></h4>
                    <table class="table" id="barcode_table">
                        <thead>
                            <tr class="w3-grey">
                                <th></th>
                                <th><?php echo $text['job_id']; ?></th>
                                <th><?php echo $text['job_name']; ?></th>
                                <th><?php echo $text['system_barcode']; ?></th>
                                <th><?php echo $text['system_barcode_from']; ?></th>
                                <th><?php echo $text['system_barcode_to']; ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            foreach ($data['barcodes'] as $row){
                                echo "<td class='' style=' text-align: center; '><input type='checkbox' class=\"job_barcode\" style='zoom: 2;' name='barcodes[]' value='{$row['barcode_selected_job']}'></td>";
                                echo "<td class=''><button class=\"job_barcode\" onclick='load_barcode({$row['barcode_selected_job']});'>{$row['barcode_selected_job']}</button></td>";
                                echo "<td class=''>{$row['job_name']}</td>";
                                echo "<td class=''>{$row['barcode']}</td>";
                                echo "<td class=''>{$row['barcode_mask_from']}</td>";
                                echo "<td class=''>{$row['barcode_mask_count']}</td>";
                                echo "</tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                    <hr>

                    <div class="row">
                        <div class="col-5 t1"><?php echo $text['system_barcode']; ?>:</div>
                        <div class="col t2">
                            <input id="barcode_name" name="barcode_name" style="height: 32px" type="text" value="" maxlength="54" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 t1"><?php echo $text['system_barcode_match_from']; ?>:</div>
                        <div class="col-6 t2">
                            <input id="barcode_from" name="barcode_from" style="height: 32px" type="text" value="" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 t1"><?php echo $text['system_barcode_match_to']; ?>:</div>
                        <div class="col-6 t2">
                            <input id="barcode_count" name="barcode_count" style="height: 32px" type="text" value="" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 t1"><?php echo $text['system_barcode_mode']; ?>:</div>
                        <div class="col-6 t2">
                            <select class="form-select" id="barcode_mode">
                                <option value="0"><?php echo $text['system_barcode_mode_0']; ?></option>
                                <option value="1"><?php echo $text['system_barcode_mode_1']; ?></option>
                                <option value="2"><?php echo $text['system_barcode_mode_2']; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 t1"><?php echo $text['system_barcode_select_job']; ?>:</div>
                        <div class="col-7 t2">
                            <select class="form-select" id="Job_Select" name="Job_Select" onchange="seq_update();">
                                <option value="-1"><?php echo $text['system_barcode_select_job_m']; ?></option>
                                <?php
                                foreach ($data['job_list'] as $key => $value) {
                                    if($value['job_id'] < 100){
                                       echo "<option value='".$value['job_id']."' > Nor-".$value['job_id']." ".$value['job_name']."</option>";
                                    }else{
                                      echo "<option value='".$value['job_id']."' > Adv-".$value['job_id']." ".$value['job_name']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="Seq_Select_div" style="display:none;">
                        <div class="col-5 t1"><?php echo $text['system_barcode_select_seq']; ?>:</div>
                        <div class="col-5 t2">
                            <select class="form-select" id="Seq_Select" name="Seq_Select">
                                <option value="-1"><?php echo $text['system_barcode_select_seq_m']; ?></option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div style="text-align: center;margin-top:5px">
                        <input class="all-btn w3-submit w3-border w3-round" style=" margin-bottom: 10px; width: 80px" type="submit" onclick="update_barcode();" value="<?php echo $text['save']; ?>">&nbsp;
                        <input class="all-btn w3-submit w3-border w3-round" style=" margin-bottom: 10px; width: 80px" type="submit" onclick="delete_barcode();" value="<?php echo $text['Delete']; ?>">
                    </div>


                </div>
            </div>

            <!-- Connect -->
            <div id="Connect_Setting" style="padding: 5px; overflow-x: hidden; display: none;">
                <div class="container div-setting">
                    <?php if($_SESSION['privilege'] == 'admin'){ ?>
                    <div class="row border-bottom">
                        <div class="col-4 t1" style="font-weight: bolder"><?php echo $text['system_connect_number']; ?></div>
                            <div class="col t2">
                                <form id="edit_max_link" onsubmit="set_max_link();return false;" method="post">
                                    <input type="text"name="max_user"id="max_user"inputmode="numeric"pattern="[0-9]*" min='1' size="10" maxlength="2" required class="w3-submit w3-border" style="font-size: 14px; height: 32px" required>
                                    <span><?php echo $text['system_connect_max_number']; ?>：<?php echo $data['max_user']; ?></span>
                                    <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right">
                                </form>
                            </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col-4 t1" style=" font-weight: bolder"><?php echo $text['system_connect_guest_pwd']; ?></div>
                        <div class="col t2">
                            <form id="edit_guest_password" onsubmit="set_guest_password();return false;" method="post">
                                <input type="password" id="new_password_guest" placeholder="<?php echo $text['system_new_password']; ?>" size="20" maxlength="15" required class="w3-submit w3-border" style="font-size: 14px; height: 32px; margin-bottom:2px">
                                <input type="password" id="comfirm_password_guest" placeholder="<?php echo $text['system_confirm_password']; ?>" size="20" maxlength="15" required class="w3-submit w3-border" style="font-size: 14px; height: 32px; margin-bottom:2px">
                                <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right;">
                            </form>
                        </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col-4 t1" style=" font-weight: bolder; ">Agent IP</div>
                        <div class="col t2">
                            <form id="agent_ip" onsubmit="set_agent_ip();return false;" method="post">
                                <input type="text"name="agent_server_ip"id="agent_server_ip" required class="w3-submit w3-border" style="font-size: 14px; height: 32px;" required>
                                <span>Agent IP：<?php echo $data['agent_server_ip']; ?></span>
                                <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 t1" style=" font-weight: bolder; ">Agent Type</div>
                        <div class="col t2">
                            <form id="agent_type_form" onsubmit="set_agent_type();return false;" method="post" style="margin-bottom: 10px">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="agent_type" id="agent_type_0" value="0">
                                    <label class="form-check-label" for="agent_type_0">None</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="agent_type" id="agent_type_1" value="1">
                                    <label class="form-check-label" for="agent_type_1">Client</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="agent_type" id="agent_type_2" value="2" required>
                                    <label class="form-check-label" for="agent_type_2">Server</label>
                                </div>

                                <input type="submit" value="<?php echo $text['save']; ?>" class="all-btn w3-submit w3-border w3-round-large" style="float: right">
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-4 t1"></div>
                            <div class="col-7 t2">
                                <span>Client Status：<div id="c_status" style="display:inline-block;"></div></span>
                                <span>Server Status：<div id="s_status" style="display:inline-block;"></div></span>

                                <button class="all-btn w3-button w3-border w3-round-large" onclick="StatusCheck();" style="margin: 5px">Check</button>
                                <button class="all-btn w3-button w3-border w3-round-large" onclick="StatusCheck('start');" style="margin: 5px;">START</button>
                                <button class="all-btn w3-button w3-border w3-round-large" onclick="StatusCheck('stop');" style="margin: 5px">STOP</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="?url=Admins/DeleteSession" method="post" style="padding: 0px 5px; ">
                        <div class="table-responsive">
                            <table class="table">
                                <tr class="table-success">
                                    <th class='' style=' text-align: center; '><?php echo $text['select']; ?></th>
                                    <th class=''><?php echo $text['system_connect_username']; ?></th>
                                    <th class=''>IP</th>
                                    <th class=''><?php echo $text['system_connect_timestamp']; ?></th>
                                </tr>
                                <?php

                                foreach ($data['active_session'] as $row){
                                    echo "<tr class='table-light'>";
                                    echo "<td class='' style=' text-align: center; '><input type='checkbox' style='zoom: 1.5;' name='sessions[]' value='{$row['id']}'></td>";
                                    echo "<td class=''>{$row['username']}</td>";
                                    echo "<td class=''>{$row['ip']}</td>";
                                    echo "<td class=''>{$row['timestamp']}</td>";
                                    echo "</tr>";
                                }

                                ?>
                            </table>
                        <?php
                            if($_SESSION['privilege'] == 'admin'){
                                echo "<input type='submit' style='float: right; margin-bottom: 5px' class='all-btn w3-submit w3-border w3-round-large' value='{$text['delete_text']}'>";
                            }
                        ?>
                        </div>
                    </form>
                    <?php } ?>
                    <!-- <div class="row">
                        <div class="col-4 t1" style=" font-weight: bolder"><?php echo $text['csv_file_path']; ?></div>
                        <div class="col t2">
                            <form id="edit_csv_file_path" onsubmit="set_csv_file_path();return false;" method="post">
                                <input type="text"name="csv_file_path"id="csv_file_path" required class="w3-submit w3-border" style="font-size: 14px; height: 32px; padding: 5px;" required>&nbsp;
                                <input type="submit" value="<?php echo $text['save']; ?>" style="font-size: 16px; height: 35px; width: 80px" class="w3-submit w3-border w3-round-large">
                            </form>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- iDas Update -->
            <div id="iDas-Update_Setting" style="padding: 10px; overflow-x: hidden; display: none;">
                <div class="container div-setting" style="padding: 10px">
                   <!--  <form action="upload.php" method="post" enctype="multipart/form-data">
                        Select file to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload File" name="submit">
                    </form> -->
                    <!-- <input type="file" id="file-uploader" data-target="file-uploader" accept="image/*" /> -->

                    <div class="row" style=" margin-bottom: 2%">
                        <div class="col-5 t1">Current iDAS Version :</div>
                        <div class="col-6 t2">
                            <input id="idas_software_version" name="idas_software_version" style="height: 35px" type="text" value="<?php echo $data['iDas_Vesion']; ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <!-- <div class="row" style=" margin-bottom: 2%">
                        <div class="col-5 t1">Current iDAS DB Version :</div>
                        <div class="col-6 t2">
                            <input id="idas_db_version" name="idas_db_version" style="height: 35px" type="text" value="" class="form-control" disabled>
                        </div>
                    </div> -->
                    <div class="row" style=" margin-bottom: 2%">
                        <div class="col-5 t1">Upload file :</div>
                        <div class="col-6 t2">
                            <input type="file" id="file-uploader" data-target="file-uploader" accept=".pack" style="height: 35px" class="form-control">
                        </div>
                        <!--  <div class="col t2">
                            <input style="font-size: 16px; height: 40px; width: 85px" class="w3-submit w3-border-gray w3-round" type="submit"  value="Load">
                        </div> -->
                    </div>
                    <hr>
                    <div style="text-align: center;margin-top:5px; margin-bottom: 10px">
                        <input class="all-btn w3-submit w3-border w3-round-large" type="button" value="Update" onclick="idas_update();">&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        let t_unit = document.getElementById('t_unit').value;
        let s_lang = document.getElementById('s_lang').value;
        let batch_mode = document.getElementById('batch_mode').value;
        let buzzer_mode = document.getElementById('buzzer_mode').value;
        let device_memory = document.getElementById('device_memory').value;
        let sample_rate = document.getElementById('sample_ra').value;

        document.getElementById('torque_unit').value = t_unit;
        document.getElementById('select_language').value = s_lang;
        document.getElementById('sample_rate').value = sample_rate;
        if(batch_mode == 0){
            document.getElementById('batch_mode_dec').checked = true;
        }else{
            document.getElementById('batch_mode_inc').checked = true;
        }
        if(buzzer_mode == 0){
            document.getElementById('buzzer_mode_on').checked = true;
        }else{
            document.getElementById('buzzer_mode_off').checked = true;
        }
        if(device_memory == 0){
            document.getElementById('blackout_recovery_on').checked = true;
        }else{
            document.getElementById('blackout_recovery_off').checked = true;
        }

        getCurrentSystemTime();// 初始化：顯示目前系統時間
        getDiskSpace();// 初始化：顯示目前硬碟使用容量
        getList();//檔案列表初始化
        seq_update();//seq select 初始化
        disable_barcode_job()//job select 初始化
        barcode_mask();//mask barcode
        $.fn.dataTableExt.oStdClasses.sWrapper += " table-responsive";
        new DataTable('#barcode_table', {
            // paging: false,
            responsive: true,
            searching: false,
            bInfo : false,
            "ordering": false,
            // "bPaginate": false,
            "dom": "frtip",
            "pageLength": 5,
            language: {
                paginate: {
                    first:    '«',
                    previous: '‹',
                    next:     '›',
                    last:     '»'
                }
            }
            
        });

        //自動切換分頁
        if( getCookie("group") == 'Barcode'){
            OpenButton('Barcode');
            document.cookie = "group=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
        }
        if( getCookie("group") == 'System'){
            OpenButton('System');
            document.cookie = "group=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
        }

        //admin connect setting
        let agent_type = <?php echo $data['agent_type']; ?>;
        document.getElementById("agent_type_"+agent_type).checked = true;
        //end admin

    });

    //-----輸入限制
    document.getElementById('control_id').addEventListener('input', function(event) { //controller id
      let inputValue = event.target.value;
      let regex = /^[0-9]*$/; // 正则表达式，匹配英文字母大小写、数字及指定符号
      if (!regex.test(inputValue)) {
        event.target.value = inputValue.slice(0, -1); // 移除最后一个输入的字符
      }
      if (inputValue >255 ) {
        event.target.value = 255; // 移除最后一个输入的字符
      }
    });
    document.getElementById('control_name').addEventListener('input', function(event) { //controller name
      let inputValue = event.target.value;
      let regex = /^[a-zA-Z0-9.\-_]*$/; // 正则表达式，匹配英文字母大小写、数字及指定符号
      if (!regex.test(inputValue)) {
        event.target.value = inputValue.slice(0, -1); // 移除最后一个输入的字符
      }
    });
    document.getElementById('Diskfull_Warning').addEventListener('input', function(event) { // Diskfull_Warning
      let inputValue = event.target.value;
      let regex = /^[0-9]*$/; // 正则表达式，匹配英文字母大小写、数字及指定符号
      if (!regex.test(inputValue)) {
        event.target.value = inputValue.slice(0, -1); // 移除最后一个输入的字符
      }
      if (inputValue > 95 ) {
        event.target.value = 95; // 移除最后一个输入的字符
      }
      if (inputValue < 50 ) {
        event.target.value = 50; // 移除最后一个输入的字符
      }
    });
    document.getElementById('Torque_Filter').addEventListener('input', function(event) {
      let inputValue = event.target.value;
      let regex = /^(0(\.\d{1,6})?|[1-9]\d{0,7}(\.\d{1,6})?)$/;

      if (!regex.test(inputValue)) {
        event.target.value = inputValue.slice(0, -1);
      }
    });
    //-----end 輸入限制

    function control_setting(argument) {
        let formData = $('#con_setting').serializeArray();

        $.ajax({
            type: "post",
            data: formData,
            dataType: "json",
            url: "?url=Settings/control_setting",
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(data) { //成功且有回傳值才會執行
            setTimeout(function() {
                $('#overlay').addClass('hidden');
                location.reload();
            }, 500);
            if (data.error != '') {
                alert('sync error');
            }
            // location.reload();

        });
    }

    function set_password(){
        let pass1 = document.getElementById('new_password').value;
        let pass2 = document.getElementById('comfirm_password').value;
        let title = '<?php echo $text['system_password_notice']; ?>';
        if (pass1 === pass2){
            Swal.fire({
                title: title,
                showCancelButton: true,
                confirmButtonText: '<?php echo $text['confirm'];?>',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    if (pass1 === pass2 && pass1 != '') {
                        $.ajax({
                            type: "GET",
                            data: { new_password: pass1, comfirm_password: pass2 },
                            dataType: "json",
                            url: "?url=Settings/edit_password",
                            beforeSend: function() {
                                $('#overlay').removeClass('hidden');
                            },
                        }).done(function(data) { //成功且有回傳值才會執行
                            setTimeout(function() {
                                $('#overlay').addClass('hidden');
                            }, 1000);
                            if (data.error != '') {
                                alert('sync error');
                            }
                            location.reload();

                        });
                    } else {
                        alert('<?php echo $text['system_password_diff']; ?>');
                    }
                }
            })
        } else {
            alert('<?php echo $text['system_password_diff']; ?>');
        }
    }

    function Permission_Change() {
        let Permission_Confirm = document.getElementById('Permission_Confirm').checked;
        let Permission_Clear = document.getElementById('Permission_Clear').checked;
        let Permission_Seq_Clear = document.getElementById('Permission_Seq_Clear').checked;
        let Permission_SW = document.getElementById('Permission_SW').checked;
        let Permission_Export = document.getElementById('Permission_Export').checked;
        let Permission_Barcode = document.getElementById('Permission_Barcode').checked;

        $.ajax({
            type: "POST",
            data: { 'Permission_Confirm': Permission_Confirm,
                    'Permission_Clear': Permission_Clear,
                    'Permission_Seq_Clear': Permission_Seq_Clear,
                    'Permission_SW': Permission_SW,
                    'Permission_Export': Permission_Export,
                    'Permission_Barcode': Permission_Barcode
             },
            dataType: "json",
            url: "?url=Settings/edit_permission",
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(data) { //成功且有回傳值才會執行
            setTimeout(function() {
                $('#overlay').addClass('hidden');
            }, 300);
            if (data.error != '') {
                alert('sync error');
            }
            
        }).fail(function (jqXHR, textStatus, errorThrown) { $('#overlay').addClass('hidden'); });
        
    }


    //-----------------------------------------------------------------------------------

    function change_datetime(argument) {
        let dateTimeInput = document.getElementById('newTime');
        $.ajax({
            type: "post",
            data: {'datetime':dateTimeInput.value},
            dataType: "json",
            url: "?url=Settings/edit_system_date",
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(data) { //成功且有回傳值才會執行
            setTimeout(function() {
                $('#overlay').addClass('hidden');
            }, 1000);
            if (data.error != '') {
                alert('sync error');
            }else{
                location.reload();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) { $('#overlay').addClass('hidden'); });

    }    

    function getCurrentSystemTime() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var serverTime = xhr.responseText;
                updateCurrentTime(serverTime);
            }
        };

        xhr.open("GET", "?url=Settings/get_system_time", true);
        xhr.send();
    }

    function updateCurrentTime(serverTime) {
        var currentTimeElement = document.getElementById("currentSystemTime");
        var serverDateTime = new Date(serverTime);
    
        setInterval(function() {
            serverDateTime.setSeconds(serverDateTime.getSeconds() + 1);
            currentTimeElement.textContent = serverDateTime.toLocaleString();
        }, 1000);
    }

    function getDiskSpace() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var usage = xhr.responseText;
                document.getElementById('disk_usage').innerHTML = usage+'%';
                if(usage <= 5){ usage = 10;}
                document.getElementById('disk_usage').style.width = usage+'%';
                document.getElementById('disk_usage').style.padding = 0;
                
            }
        };

        xhr.open("GET", "?url=Settings/system_storage", true);
        xhr.send();
    }

    function Export_SystemConfig(argument) {

        var xhr = new XMLHttpRequest();
        // 設置回應類型為二進位檔案
        xhr.responseType = "blob";
        // 當下載完成時執行的函數
        xhr.onload = function() {
            if (xhr.status === 200) {
                // 創建一個 <a> 元素來觸發下載
                var a = document.createElement("a");
                a.href = window.URL.createObjectURL(xhr.response);
                a.download = "tcscon.cfg"; // 下載時的檔案名稱
                a.style.display = "none";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        };

        xhr.open("GET", "?url=Settings/export_sysytem_config", true);
        xhr.send();
    }

    function Import_SystemConfig(argument) {

        let bb = document.getElementById("import-file-uploader").files[0];
        let form = new FormData();
        form.append("file", bb)
        let url = '?url=Settings/Import_Config';        

        if(bb == undefined){
            
        }else{
            $.ajax({ // 提醒
                type: "POST",
                processData: false,
                cache: false,
                contentType: false,
                data: form,
                dataType: "json",
                url: url,
                beforeSend: function() {
                    $('#overlay').removeClass('hidden');
                },
            }).done(function(result) { //成功且有回傳值才會執行
                $('#overlay').addClass('hidden');
                document.getElementById("import-file-uploader").value = '';
            });
        }
    }

    function Firmware_Update(argument) {

        let bb = document.getElementById("firmware-file-uploader").files[0];
        let form = new FormData();
        form.append("file", bb)
        let url = '?url=Settings/FirmwareUpdate';

        if(bb == undefined){

        }else{
            $.ajax({ // 提醒
                type: "POST",
                processData: false,
                cache: false,
                contentType: false,
                data: form,
                dataType: "json",
                url: url,
                beforeSend: function() {
                    $('#overlay').removeClass('hidden');
                },
            }).done(function(result) { //成功且有回傳值才會執行
                $('#overlay').addClass('hidden');
                document.getElementById("firmware-file-uploader").value = '';
            });
        }
        
    }


    function getList(argument) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?url=Settings/get_file_list", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var fileList = JSON.parse(xhr.responseText);
                displayFileList(fileList);
            }
        };
        xhr.send();

    }

    function displayFileList(fileList) {
        var fileListContainer = document.getElementById("fileList");
        fileListContainer.innerHTML = ""; //clear
        var fileListArray = Array.from(fileList);

        fileListArray.forEach(function(fileName) {
            var label = document.createElement("label");
            label.textContent = fileName;

            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.style.zoom = '1.5';
            checkbox.style.verticalAlign = 'middle';
            checkbox.style.marginLeft = '5px';
            checkbox.name = "selectedFiles[]";
            checkbox.value = fileName;

            label.appendChild(checkbox);
            fileListContainer.appendChild(label);
            fileListContainer.appendChild(document.createElement("br"));
        });
    }

    // 刪除選擇的檔案
    function deleteSelectedFiles() {
        var selectedFiles = document.querySelectorAll('input[name="selectedFiles[]"]:checked');
        var selectedFileNames = Array.from(selectedFiles).map(function(checkbox) {
            return checkbox.value;
        });

        if (selectedFileNames.length === 0) {
            alert("<?php echo $text['system_db_del_notice']; ?>");
            return;
        }

        // 使用 XMLHttpRequest 向後端發送刪除請求
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "?url=Settings/delete_files", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                // document.getElementById("resultMessage").textContent = response.message;
                alert(response.message)
                // 重新載入檔案清單
                getList();
                // location.reload();
            }
        };

        xhr.send(JSON.stringify({ files: selectedFileNames }));
    }

    function ToolSelect(argument) {
        let tool_type = document.getElementById("tool_type").value;
        let url = '?url=Admins/Tool_Select';
        console.log(tool_type);
        $.ajax({ // 提醒
            type: "POST",
            data: {'tool_type':tool_type},
            dataType: "json",
            url: url,
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(result) { //成功且有回傳值才會執行
            $('#overlay').addClass('hidden');
            document.cookie = "group=System";
            location.reload();
            // document.getElementById("firmware-file-uploader").value = '';
        });
    }


    //--------barcode setting----------

    function update_barcode() {
        let barcode_name = document.getElementById("barcode_name");
        let barcode_from = document.getElementById("barcode_from");
        let barcode_count = document.getElementById("barcode_count");
        let barcode_mode = document.getElementById("barcode_mode");
        let Job_Select = document.getElementById("Job_Select");
        let Seq_Select = document.getElementById("Seq_Select");
        let Seq_Select_value = 0;

        if(barcode_name.value == ''){
            Swal.fire({ 
                title: 'Error',
                text: "<?php echo $text['system_barcode_notice_4']; ?>",
            })
            return;
        }

        if(barcode_mode.value == 2){ // mode = 2 才會抓取seq select值
            Seq_Select_value = Seq_Select.value;
        }

        if (Job_Select.value == -1) { 
            Swal.fire({ 
                title: 'Error',
                text: "<?php echo $text['system_barcode_notice_1']; ?>",
            })
            return;
        }
        //from match驗證
        if(barcode_from.value < 1 || barcode_from.value > barcode_name.value.length){
            Swal.fire({ 
                title: 'Error',
                text: "<?php echo $text['system_barcode_notice_2']; ?>",
            })
            return;
        }

        if (barcode_count.value < 1 || (parseInt(barcode_count.value) + parseInt(barcode_from.value) ) > (barcode_name.value.length + 1)) {
            Swal.fire({ 
                title: 'Error',
                text: "<?php echo $text['system_barcode_notice_3']; ?>",
            })
            return;
        }

        $.ajax({
            type: "post",
            data: 
            {
                'barcode_name':barcode_name.value,
                'barcode_from':barcode_from.value,
                'barcode_count':barcode_count.value,
                'barcode_mode':barcode_mode.value,
                'Job_Select':Job_Select.value,
                'Seq_Select':Seq_Select_value,
            },
            dataType: "json",
            url: "?url=Settings/Update_Barcode",
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(data) { //成功且有回傳值才會執行
            setTimeout(function() {
                $('#overlay').addClass('hidden');
            }, 1000);
            if (data.error_message != '') {
                alert(data.error_message);
            }else{
                document.cookie = "group=Barcode";
                location.reload();
                // location.reload();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) { $('#overlay').addClass('hidden'); });
    }

    function seq_update() {
        var Job_Select = document.getElementById("Job_Select");
        var Seq_Select = document.getElementById("Seq_Select");
        // 清空<select>元素的现有选项
        Seq_Select.innerHTML = "";

        // 使用AJAX请求获取选项数据
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?url=Settings/GetJobSeq&job_id=" + Job_Select.value, true); // 替换为你的数据源URL
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var optionsData = JSON.parse(xhr.responseText);

                // 添加新选项
                optionsData.forEach(function(option, index) {
                    var optionElement = document.createElement("option");
                    optionElement.value = option.sequence_id;
                    optionElement.textContent = 'Seq-' + (index + 1) + ' ' + option.sequence_name;
                    Seq_Select.appendChild(optionElement);
                });
            }
        };
        xhr.send();
    }

    function load_barcode(job_id) {
        var Barcode_name = document.getElementById("barcode_name");
        var barcode_from = document.getElementById("barcode_from");
        var barcode_count = document.getElementById("barcode_count");
        var barcode_mode = document.getElementById("barcode_mode");
        var Job_Select = document.getElementById("Job_Select");
        var Seq_Select = document.getElementById("Seq_Select");

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?url=Settings/GetJobBarcode&job_id=" + job_id, true); // 替换为你的数据源URL
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var result = JSON.parse(xhr.responseText);

                // 添加新选项
                result.forEach(function(option, index) {
                    Barcode_name.value = option.barcode;
                    barcode_from.value = option.barcode_mask_from;
                    barcode_count.value = option.barcode_mask_count;
                    barcode_mode.value = option.barcode_enable;
                    Job_Select.value = option.barcode_selected_job;
                    Seq_Select.value = option.barcode_selected_seq;
                    seq_update()
                    if(barcode_mode.value == 2){
                        document.getElementById("Seq_Select_div").style.display = 'flex';
                    }else{
                        document.getElementById("Seq_Select_div").style.display = 'none';
                    }
                });
            }
        };
        xhr.send();
    }

    function delete_barcode(argument) {
        var selectedbarcodes = document.querySelectorAll('input[name="barcodes[]"]:checked');
        var selectedJobs = Array.from(selectedbarcodes).map(function(checkbox) {
            return checkbox.value;
        });


        if (selectedJobs.length === 0) {
            Swal.fire({ 
                title: 'Error',
                text: "<?php echo $text['system_barcode_del_notice']; ?>",
            })
            return;
        }else{
            Swal.fire({
            title: "<?php echo $text['system_barcode_del_notice2']; ?>",
            showCancelButton: true,
            confirmButtonText: '<?php echo $text['confirm'];?>',
            cancelButtonText:'<?php echo $text['cancel'];?>',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    // 使用 XMLHttpRequest 向後端發送刪除請求
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "?url=Settings/delete_barcodes", true);
                    xhr.setRequestHeader("Content-Type", "application/json");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            document.cookie = "group=Barcode";
                            location.reload();
                        }
                    };

                    xhr.send(JSON.stringify({ jobs: selectedJobs }));
                }

            })
        }        
    }

    function disable_barcode_job() {
        table_id = 'barcode_table';
        var table = document.getElementById(table_id);
        var rows = table.getElementsByTagName("tr");
        var selectMenu = document.getElementById("Job_Select");
        var options = selectMenu.options;

        for (var i = 1; i < rows.length; i++) {
            var row = rows[i];
            var cell = row.getElementsByTagName("td")[0];
            var optionValue = cell.getElementsByTagName("input")[0].value;

            for (var j = 0; j < options.length; j++) {
                if (options[j].value === optionValue) {
                    options[j].disabled = true;
                    break;
                }
            }
        }
    }

    function barcode_mask() {
        table_id = 'barcode_table';
        let table = document.getElementById(table_id);
        let rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            let barcode = row.getElementsByTagName("td")[3].innerHTML;
            let from = row.getElementsByTagName("td")[4].innerHTML;
            let count = row.getElementsByTagName("td")[5].innerHTML;

            let result = replaceWithAsterisks(barcode,from-1,count);
            row.getElementsByTagName("td")[3].innerHTML = result;

        }
    }

    function replaceWithAsterisks(str, from, count) {
        // 使用 parseInt() 将 from、count 和 str.length 转换为整数
        from = parseInt(from, 10);
        count = parseInt(count, 10);
        
        if (typeof str !== 'string' || isNaN(from) || isNaN(count) || from < 0 || count <= 0 || parseInt(from) + parseInt(count) > str.length) {
            return 'Invalid input';
        }

        let prefixLength = from; // 从字符串开头到 from 的字符数
        let preservedLength = count; // 保留的字符数
        let suffixLength = str.length - from - count; // 从 from + count 到字符串末尾的字符数

        let prefix = '*'.repeat(prefixLength); // 生成前缀的 *
        let preserved = str.substring(from, from + preservedLength); // 保留的部分
        let suffix = '*'.repeat(suffixLength); // 生成后缀的 *

        return prefix + preserved + suffix;

    }


    // 获取输入框和输出框的元素
        var inputField = document.getElementById("barcode_name");
        var Barcode_mode = document.getElementById("barcode_mode");
        var Job_Select = document.getElementById("Job_Select");
        var Seq_Select = document.getElementById("Seq_Select");
        var barcode_from = document.getElementById("barcode_from");
        var barcode_count = document.getElementById("barcode_count");


        // 监听Barcode 將單引號轉換為雙引號
        inputField.addEventListener("input", function() {
            // 获取输入框的值
            var inputValue = inputField.value;
            
            // 使用正则表达式替换所有单引号为双引号
            var replacedValue = inputValue.replace(/'/g, '"');
            // 更新输出框的内容
            inputField.value = replacedValue;
        });

        // 监听Barcode mode == 2
        Barcode_mode.addEventListener("change", function() {
            // 获取输入框的值
            var inputValue = Barcode_mode.value;
            if(inputValue == 2){
                //動態載入job的seq
                document.getElementById("Seq_Select_div").style.display = 'flex';
            }else{
                document.getElementById("Seq_Select_div").style.display = 'none';
            }
        });

        // 监听Barcode 輸入完成後自動帶入值給From 與 to
        inputField.addEventListener("blur", function() {
            // 获取输入框的值
            var inputValue = inputField.value;
            if(inputValue != ''){
                barcode_from.value = 1;
                barcode_count.value = inputValue.length;
            }else{
                barcode_from.value = '';
                barcode_count.value = '';
            }
        });

        // 监听barcode_from
        barcode_from.addEventListener("blur", function() {
            // 获取输入框的值
            let length = inputField.value.length;
            if(barcode_from.value > length){
                barcode_from.value = length;
            }
            if(barcode_from.value < 1){
                barcode_from.value = 1;
            }


            let bcv = parseInt(length) - parseInt(barcode_from.value) + 1;
            if(bcv <= 1){ bcv = 1;}
            barcode_count.value = bcv;
        });

    //--------end barcode setting----------

    //-------- iDAS Connect Setting
    function set_max_link(argument) {
        let max_user = document.getElementById('max_user').value;

        $.ajax({ // 提醒
            type: "POST",
            data: { 'max_user': max_user },
            dataType: "json",
            url: "?url=Admins/EditMaxLink",
        }).done(function(notice) { //成功且有回傳值才會執行
            if (notice.error != '') {
                Swal.fire({ // DB sync notice
                    title: 'Error',
                    text: notice.error,
                })
            } else {
                Swal.fire('Saved!', '', 'success');
                document.getElementById('max_user').value = '';
                window.location = window.location.href;
            }
        });
    }


    function set_guest_password(){
        let pass1 = document.getElementById('new_password_guest').value;
        let pass2 = document.getElementById('comfirm_password_guest').value;
        let title = '<?php echo $text['system_password_notice']; ?>';
        let message = '';

        // 正则表达式，至少包含一个字母和一个数字
        var pattern = /^(?=.*[A-Za-z])(?=.*\d).{4,}$/;
        if (!pattern.test(pass1)) {
            message = "<?php echo $text['system_password_require']; ?>";
            Swal.fire(message, '', 'warning');
            return;
        }


        if (pass1 === pass2 && pass1 != '') {
            $.ajax({
                type: "POST",
                data: { new_password: pass1, comfirm_password: pass2 },
                dataType: "json",
                url: "?url=Admins/EditGuestPwd",
                beforeSend: function() {
                    // $('#overlay').removeClass('hidden');
                },
            }).done(function(data) { //成功且有回傳值才會執行
                setTimeout(function() {
                    // $('#overlay').addClass('hidden');
                }, 1000);
                if (data.error != '') {
                    alert('sync error');
                }else{
                    Swal.fire('Saved!', '', 'success');
                    document.getElementById('new_password_guest').value = '';
                    document.getElementById('comfirm_password_guest').value = '';
                    // window.location = window.location.href;
                }
            });
        } else {
            Swal.fire('<?php echo $text['system_password_diff']; ?>', '', 'warning');
        }
    }

    function set_agent_ip(argument) {
        let agent_server_ip = document.getElementById('agent_server_ip').value;
        agent_server_ip = agent_server_ip.replace(/\s*/g,""); //去除空白
        $.ajax({ // 提醒
            type: "POST",
            data: { 'ip': agent_server_ip },
            dataType: "json",
            url: "?url=Admins/SetAgentIp",
        }).done(function(notice) { //成功且有回傳值才會執行
            if (notice.error != '') {
                Swal.fire({ // DB sync notice
                    title: 'Error',
                    text: notice.error,
                })
            } else {
                Swal.fire('Saved!', '', 'success');
                document.getElementById('agent_server_ip').value = '';
                window.location = window.location.href;
            }
        });
    }

    function set_agent_type(argument) {
        let agent_type = document.querySelector('input[name="agent_type"]:checked').value;
        $.ajax({ // 提醒
            type: "POST",
            data: { 'agent_type': parseInt(agent_type) },
            dataType: "json",
            url: "?url=Admins/SetAgentType",
        }).done(function(notice) { //成功且有回傳值才會執行
            if (notice.error != '') {
                Swal.fire({ // DB sync notice
                    title: 'Error',
                    text: notice.error,
                })
            } else {
                Swal.fire('Saved!', '', 'success');
                // document.getElementById('agent_server_ip').value = '';
                // window.location = window.location.href;
            }
        });
    }

    function StatusCheck(action) {
        let work_icon = '<svg height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M9.001.666A8.336 8.336 0 0 0 .668 8.999c0 4.6 3.733 8.334 8.333 8.334s8.334-3.734 8.334-8.334S13.6.666 9 .666Zm0 15a6.676 6.676 0 0 1-6.666-6.667A6.676 6.676 0 0 1 9 2.333a6.676 6.676 0 0 1 6.667 6.666A6.676 6.676 0 0 1 9 15.666Zm-1.666-4.833L5.168 8.666 4.001 9.833l3.334 3.333L14 6.499l-1.166-1.166-5.5 5.5Z" fill="#1E8E3E" fill-rule="evenodd"></path></svg>';
        let not_work_icon = '<svg height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M11.16 5.666 9 7.824 6.843 5.666 5.668 6.841l2.158 2.158-2.158 2.159 1.175 1.175 2.158-2.159 2.159 2.159 1.175-1.175-2.159-2.159 2.159-2.158-1.175-1.175ZM9 .666A8.326 8.326 0 0 0 .668 8.999a8.326 8.326 0 0 0 8.333 8.334 8.326 8.326 0 0 0 8.334-8.334A8.326 8.326 0 0 0 9 .666Zm0 15a6.676 6.676 0 0 1-6.666-6.667A6.676 6.676 0 0 1 9 2.333a6.676 6.676 0 0 1 6.667 6.666A6.676 6.676 0 0 1 9 15.666Z" fill="#D93025" fill-rule="evenodd"></path></svg>';

        let url = '?url=Admins/AgentTest';
        if(action == 'start'){
            url = '?url=Admins/StartAgent';
        }
        if(action == 'stop'){
            url = '?url=Admins/CloseAgent';
        }

        $.ajax({ // 提醒
            type: "POST",
            data: { },
            dataType: "json",
            url: url,
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(result) { //成功且有回傳值才會執行
            $('#overlay').addClass('hidden');
            if(result.server_status == "true"){
                document.getElementById('s_status').innerHTML = work_icon;
            }else{
                document.getElementById('s_status').innerHTML = not_work_icon;
            }
            if(result.client_status == "true"){
                document.getElementById('c_status').innerHTML = work_icon;
            }else{
                document.getElementById('c_status').innerHTML = not_work_icon;
            }
        });
    }

    function set_csv_file_path(argument) {
        let csv_file_path = document.getElementById('csv_file_path').value;

        $.ajax({ // 提醒
            type: "POST",
            data: { 'file_path': csv_file_path },
            dataType: "json",
            url: "?url=Admins/EditCsvPath",
        }).done(function(notice) { //成功且有回傳值才會執行
            if (notice.error != '') {
                Swal.fire({ // DB sync notice
                    title: 'Error',
                    text: notice.error,
                })
            } else {
                Swal.fire('Saved!', '', 'success');
                document.getElementById('csv_file_path').value = '';
                window.location = window.location.href;
            }
        });
    }


</script>

<script type="text/javascript">
    function OpenButton(ButtonMode)
    {
        if (ButtonMode == "Controller")
        {
            document.getElementById('Controller_Setting').style.display = "";
            document.getElementById('System_Setting').style.display = "none";
            document.getElementById('Barcode_Setting').style.display = "none";
            document.getElementById('Connect_Setting').style.display = "none";
            document.getElementById('iDas-Update_Setting').style.display = "none";
            document.getElementById('bnt1').classList.add("active");
            document.getElementById('bnt2').classList.remove("active");
            document.getElementById('bnt3').classList.remove("active");
            document.getElementById('bnt4').classList.remove("active");
            document.getElementById('bnt5').classList.remove("active");
         }
        else if (ButtonMode == "System")
        {
            document.getElementById('System_Setting').style.display = "";
            document.getElementById('Controller_Setting').style.display = "none";
            document.getElementById('Barcode_Setting').style.display = "none";
            document.getElementById('Connect_Setting').style.display = "none";
            document.getElementById('iDas-Update_Setting').style.display = "none";
            document.getElementById('bnt2').classList.add("active");
            document.getElementById('bnt1').classList.remove("active");
            document.getElementById('bnt3').classList.remove("active");
            document.getElementById('bnt4').classList.remove("active");
            document.getElementById('bnt5').classList.remove("active");
        }
        else if (ButtonMode == "Barcode")
        {
            document.getElementById('Barcode_Setting').style.display = "";
            document.getElementById('System_Setting').style.display = "none";
            document.getElementById('Controller_Setting').style.display = "none";
            document.getElementById('Connect_Setting').style.display = "none";
            document.getElementById('iDas-Update_Setting').style.display = "none";
            document.getElementById('bnt3').classList.add("active");
            document.getElementById('bnt2').classList.remove("active");
            document.getElementById('bnt1').classList.remove("active");
            document.getElementById('bnt4').classList.remove("active");
            document.getElementById('bnt5').classList.remove("active");
        }
        else if (ButtonMode == "Connect")
        {
            document.getElementById('Connect_Setting').style.display = "";
            document.getElementById('Barcode_Setting').style.display = "none";
            document.getElementById('System_Setting').style.display = "none";
            document.getElementById('Controller_Setting').style.display = "none";
            document.getElementById('iDas-Update_Setting').style.display = "none";
            document.getElementById('bnt4').classList.add("active");
            document.getElementById('bnt3').classList.remove("active");
            document.getElementById('bnt2').classList.remove("active");
            document.getElementById('bnt1').classList.remove("active");
            document.getElementById('bnt5').classList.remove("active");
        }
        else if (ButtonMode == "Update")
        {
            document.getElementById('iDas-Update_Setting').style.display = "";
            document.getElementById('Connect_Setting').style.display = "none";
            document.getElementById('Barcode_Setting').style.display = "none";
            document.getElementById('System_Setting').style.display = "none";
            document.getElementById('Controller_Setting').style.display = "none";
            document.getElementById('bnt5').classList.add("active");
            document.getElementById('bnt4').classList.remove("active");
            document.getElementById('bnt3').classList.remove("active");
            document.getElementById('bnt2').classList.remove("active");
            document.getElementById('bnt1').classList.remove("active");
        }
        else
        {
            alert("Function ["+ ButtonMode +"] is under constructing ...");
        }
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        //alert(document.cookie);
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(nameEQ) != -1) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }


</script>


<!-- 軟體更新 -->
<script type="text/javascript">
        const fileUploader = document.querySelector('#file-uploader');

        function idas_update() {
            let ff = document.querySelector('#file-uploader').files;
            let bb = document.getElementById("file-uploader").files[0];
            let form = new FormData();
            form.append("file", bb)

            let url = '?url=Settings/iDas_Update';
            $.ajax({ // 提醒
                type: "POST",
                processData: false,
                cache: false,
                contentType: false,
                data: form,
                dataType: "json",
                url: url,
                beforeSend: function() {
                    $('#overlay').removeClass('hidden');
                },
            }).done(function(result) { //成功且有回傳值才會執行
                $('#overlay').addClass('hidden');

                if (result.message != '') {
                    Swal.fire({ // DB sync notice
                        title: 'Error',
                        text: result.message,
                    })
                } else {
                    Swal.fire('', '', 'success');
                    setTimeout(function() {history.go(0)}, 2000);
                }
                document.getElementById("file-uploader").value = '';
                
            });
        }
    // }
</script>
<!-- end 軟體更新 -->


<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs();
    document.getElementById("home").disabled = false; 
    document.getElementById("bnt1").disabled = false; 
    document.getElementById("bnt2").disabled = false; 
    document.getElementById("bnt3").disabled = false; 
    document.getElementById("bnt4").disabled = false;
    document.getElementById("bnt5").disabled = false;

    var buttons = document.getElementsByClassName("job_barcode");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = false;
    }
  });
</script>
<?php } ?>

