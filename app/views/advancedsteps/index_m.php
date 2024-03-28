<link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>css/advjob_step_manager_m.css">
<script src="<?php echo URLROOT; ?>/js/advancedstep.js"></script>

<style type="text/css">
    .form-control{
        width: auto!important;
        display: initial!important;
        padding:5px;
    }
    .form-control.is-invalid{
        padding-right:inherit!important;
    }
    .is-invalid~.invalid-feedback {
/*        display: inline!important;*/
    }

</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <header id="header">
            <h3><?php echo $text['advancedstep_management']; ?></h3>
        </header>
    </div>

    <input style="display:none;" id="sequence_id" value="<?php echo $data['sequence_id'];?>" disabled>
    <input style="display:none;" id="sequence_name" value="<?php echo $data['sequence_name'];?>" disabled>
    <input style="display:none;" id="tool_maxtorque" value="<?php echo $data['tool_info']['tool_maxtorque'];?>" disabled>
    <input style="display:none;" id="tool_mintorque" value="<?php echo $data['tool_info']['tool_mintorque'];?>" disabled>
    <input style="display:none;" id="tool_maxrpm" value="<?php echo $data['tool_info']['tool_maxrpm'];?>" disabled>
    <input style="display:none;" id="tool_minrpm" value="<?php echo $data['tool_info']['tool_minrpm'];?>" disabled>
    <input style="display: none;"  id="torque_unit" name="torque_unit" value="<?php echo $data['controller_Info']['device_torque_unit']; ?>" disabled>
    <input style="display: none;"  id="delta" name="delta" value="<?php echo $data['delta']; ?>" disabled>

    <div class="main-content">
        <div class="center-content">
            <div id="TableJob_SeqName">
                <table class="w3-table w3-striped">
                    <tr>
                        <td>
                            <label style="color: #000" for="job_id"><?php echo $text['job_id']; ?>:</label>
                            <input style="height:33px;width: 60px; font-size:18px;text-align: center;" type="text" id="job_id" name="job_id" maxlength="20" value="<?php echo $data['job_id'];?>" disabled>
                        </td>
                        <td>
                            <label style="color: #000" for="seq_id"><?php echo $text['seq_id']; ?>:</label>
                            <input style="height:33px;width: 60px; font-size:18px;text-align: center;" type="text" id="seq_id" name="seq_id"  maxlength="20" value="<?php echo $data['sequence_id'];?>" disabled>
                        </td>
                        <td>
                            <button id="return" onclick="location.href = '?url=Sequences/index/<?php echo $data['job_id'];?>'"><?php echo $text['return']; ?></button>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="TableStepSetting" align="center">
                <div class="scrollbar table-container" id="style-step">
                    <div class="force-overflow">
                        <table id="Table_Step" class="w3-table-all w3-hoverable w3-large" style="margin: 0 !important;">
                            <thead id="header-table">
                                <tr style="height:45px; font-size:3.4vmin;" class="w3-dark-grey">
                                    <th class="w3-center" width="10%"><?php echo $text['step_id']; ?></th>
                                    <th class="w3-center" width="20%"><?php echo $text['step_name']; ?></th>
                                    <th class="w3-center" width="10%"><?php echo $text['step_target_type']; ?> </th>
                                    <th class="w3-center" width="10%"><?php echo $text['up']; ?></th>
                                    <th class="w3-center" width="10%"><?php echo $text['down']; ?></th>
                                </tr>
                            </thead>
                            <tbody style="height:40px; font-size:3.2vmin;">
                                <?php
                                    foreach ($data['advancedstep'] as $key => $value) { //sequences列表
                                        echo '<tr>';
                                        echo '<td class="w3-center">'.$value['step_id'].'</td>';
                                        echo '<td class="w3-center">'.$value['step_name'].'</td>';
                                        if($value['step_targettype'] == 1){ echo '<td class="w3-center"> '.$text['angle'] .' </td>'; }
                                        if($value['step_targettype'] == 2){ echo '<td class="w3-center"> '.$text['torque'].' </td>'; }
                                        if($value['step_targettype'] == 3){ echo '<td class="w3-center"> '.$text['time'] .' </td>'; }
                                        echo '<td class="w3-center"><button style="border:1px solid black;width:30px; height:30px; font-size: 16px;padding:0;background: url(../public/img/btn_uarrow.png) no-repeat;" onClick="MoveUp.call(this);"></button></td>
                                              <td class="w3-center"><button style="border:1px solid black;width:30px; height:30px; font-size: 16px;padding:0;background: url(../public/img/btn_darrow.png) no-repeat;" onClick="MoveDown.call(this);"></button></td>';

                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div id="TotalPage">
            <table id="TotalStepTable">
                <tr>
                    <td style="color:#000; float: left"><?php echo $text['total_step']; ?> : <input style="text-align: center" id="RecordCnt" name="RecordCnt" readonly="readonly" disabled size="3" maxlength="3" value=""> </td>
                    <!--
                    <td width="50%" align="right" style="color:white;display: none;">
                        <?php echo $text['page']; ?> : <input style="text-align: center" id="CurrentPage" name="CurrentPage" readonly="readonly" size="3" maxlength="3" value="">
                        <?php echo $text['page_of']; ?> <input style="text-align: center" id="TotalPage" name="TotalPage" readonly="readonly" size="3" maxlength="3" value=""> </td>
                    <td>
                        <input style="text-align: right" id="Total_Seq" name="Total_Seq" readonly="readonly" disabled size="3" maxlength="3" value="" hidden>
                    </td>
                    -->
                </tr>
            </table>
        </div>

        <div class="buttonbox">
            <input id="S3" name="Job_Manager_Submit" type="button" value="<?php echo $text['New']; ?>" tabindex="1" onclick="crud_job('new')">
            <input id="S6" name="Job_Manager_Submit" type="button" value="<?php echo $text['Edit']; ?>" tabindex="1" onclick="crud_job('edit')">
            <input id="S5" name="Job_Manager_Submit" type="button" value="<?php echo $text['Copy']; ?>" tabindex="1" onclick="crud_job('copy')">
            <input id="S4" name="Job_Manager_Submit" type="button" value="<?php echo $text['Delete']; ?>" tabindex="1" onclick="crud_job('del')">
        </div>
    </div>

    <!-- Step Modal -->
    <div class="container">
        <div class="w3-modal" id="StepModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="StepModalLabel" aria-hidden="true">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-light-grey" style="width: 500px;">
                <header class="w3-container w3-dark-grey ">
                    <span onclick="document.getElementById('StepModal').style.display='none'"
                        class="w3-button w3-red w3-xlarge w3-display-topright " style="margin: 2px">&times;</span>
                    <h3 id="modal_title" style="line-height: inherit; text-align: left ">New Step</h3>
                </header>
                <div class="w3-bar w3-border-bottom w3-light-grey" style=" margin-top: 3px">
                    <table class="w3-bar-item">
                        <tr>
                            <td>
                                <label  style="color: #000" for="Job_ID_div"><?php echo $text['job_id']; ?>:</label>
                                <input type="text" id="Job_ID_div" name="Job_ID_div" size="4" maxlength="10" value="<?php echo $data['job_id'];?>" disabled>
                            </td>
                        </tr>
                    </table>
                    <button style="height: 45px; width: 75px; border-radius: 5px; font-size:3.6vmin; margin-right: 3px" class="tablink w3-bar-item" id="torque_button" onclick="OpenTarget(event, 'Torque')"><?php echo $text['torque']; ?></button>
                    <button style="height: 45px; width: 75px; border-radius: 5px; font-size:3.6vmin"  class="tablink w3-bar-item" id="angle_button" onclick="OpenTarget(event, 'Angle')"><?php echo $text['angle']; ?></button>
                    <button style="height: 45px; width: 75px; border-radius: 5px; font-size:3.6vmin; display: none;"  class="tablink w3-bar-item" id="time_button" onclick="OpenTarget(event, 'Time')"><?php echo $text['time']; ?></button>
                </div>

                <div id="Torque" class="w3-container target">
                    <div class="scrollbar-modal" id="style-torque">
                        <div class="force-overflow-modal">
                          <form id="new_step_target_torque">
                            <table id="Target_Torque_Table" class="w3-large">
                                <tr>
                                    <td width= "50%">
                                        <label for=""><?php echo $text['seq_id']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control"  size="6" value="<?php echo $data['sequence_id'];?>" disabled>
                                    </td>
                                    <!-- <td width= "30%"></td> -->
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Step_ID_Torque"><?php echo $text['step_id']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_ID_Torque" name="Step_ID_Torque" size="6" disabled>
                                    </td>
                                    <!-- <td></td> -->
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Step_Name_Torque"><?php echo $text['step_name']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_Name_Torque" name="Step_Name_Torque" oninput="validateInput_advancedstep_name('Step_Name_Torque')" size="10">
                                        <div class="invalid-feedback"><?php echo $error_message['step_name']; ?></div>
                                    </td>
                                    <!-- <td></td> -->
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['direction']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="zoom:1.5; vertical-align: middle" id="Direction_CW_T" name="Direction_Option_T" value="0" type="radio">
                                        <label for="Direction_CW_T"><?php echo $text['CW']; ?></label>
                                        <input style="zoom:1.5; vertical-align: middle" id="Direction_CCW_T" name="Direction_Option_T" value="1" type="radio">
                                        <label for="Direction_CCW_T"><?php echo $text['CCW']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="RPM"><?php echo $text['Run_Down_Speed']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="RPM" name="RPM" size="6"> <?php echo $text['max_rpm'];?> <?php echo $data['tool_info']['tool_maxrpm'];?>
                                        <div class="invalid-feedback"><?php echo $error_message['Run_Down_Speed']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Delay_Time_T"><?php echo $text['delay_time']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Delay_Time_T" name="Delay_Time_T" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Delay_Time']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Target_Torque"><?php echo $text['Target_Torque']; ?> :</label>
                                    </td>
                                   <td  colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Target_Torque" name="Target_Torque" size="6"> <?php echo $text['Nm']; ?>
                                        <div class="invalid-feedback"><?php echo $error_message['Target_Torque']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['Joint_Offset']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <form id="OffSet" action="#">
                                            <select id="Joint_OffSet_Direction">
                                                <option value="0">&#43;</option>
                                                <option value="1">&#8722;</option>
                                            </select>
                                            <input style="font-size:16px; height:25px ; margin:5px" class="form-control" id="Joint_OffSet" name="Joint_OffSet" size="4">
                                            <div class="invalid-feedback"><?php echo $error_message['Joint_OffSet']; ?><span id="Offset_range"></span></div>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['Monitor_Mode']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_Window" name="Monitor_Option" value="0" type="radio">
                                        <label for="Monitor_Window"><?php echo $text['Window']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_HiLow" name="Monitor_Option" value="1" type="radio">
                                        <label for="Monitor_HiLow"><?php echo $text['Hi-Lo']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['Monitor_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_Angle_OFF" name="Monitor_Angle_Option" value="0" type="radio">
                                        <label for="Monitor_Angle_OFF"><?php echo $text['switch_off']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_Angle_ON" name="Monitor_Angle_Option" value="1" type="radio">
                                        <label for="Monitor_Angle_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Over_Ang_Stop_tr">
                                    <td>
                                        <label ><?php echo $text['Over_Angle_Stop']; ?>:</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.5; vertical-align: middle" id="Over_Ang_Stop_OFF" name="Over_Ang_Stop_Option" value="0" type="radio">
                                        <label for="Over_Ang_Stop_OFF"><?php echo $text['switch_off']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.5; vertical-align: middle" id="Over_Ang_Stop_ON" name="Over_Ang_Stop_Option" value="1" type="radio">
                                        <label for="Over_Ang_Stop_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Torque_Window_tr">
                                    <td>
                                        <label ><?php echo $text['Torque_Window']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Torque_Window_Add" name="Torque_Window_Add" size="2" disabled>
                                        <label>&#43;&#8725;&#8722;</label>
                                        <input style="font-size:16px; height:25px" class="form-control" id="Torque_Window_Subtraction" name="Torque_Window_Subtraction" size="2">
                                        <div class="invalid-feedback"><?php echo $error_message['Torque_Window_Add']; ?></div>
                                        <div class="invalid-feedback delta_alert"><?php echo $error_message['Torque_Window_Subtraction'].$data['delta']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Angle_Window_tr">
                                    <td>
                                        <label ><?php echo $text['Angle_Window']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Angle_Window_Add" name="Angle_Window_Add" size="2">
                                        <label>&#43;&#8725;&#8722;</label>
                                        <input style="font-size:16px; height:25px" class="form-control" id="Angle_Window_Subtraction" name="Angle_Window_Subtraction" size="2">
                                        <div class="invalid-feedback"><?php echo $error_message['Angle_Window_Add']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Hi_Torque_tr">
                                    <td>
                                        <label for="Hi_Torque"><?php echo $text['High_Torque']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Hi_Torque" name="Hi_Torque" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Hi_Torque']; ?><span id="HQ_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Lo_Torque_tr">
                                    <td>
                                        <label for="Lo_Torque"><?php echo $text['Low_Torque']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Lo_Torque" name="Lo_Torque" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Torque']; ?><span id="LQ_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Hi_Angle_tr">
                                    <td>
                                        <label for="Hi_Angle"><?php echo $text['High_Angle']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Hi_Angle" name="Hi_Angle" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['High_Angle']; ?><span id="HA_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Lo_Angle_tr">
                                    <td>
                                        <label for="Lo_Angle"><?php echo $text['Low_Angle']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Lo_Angle" name="Lo_Angle" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?><span id="LA_range"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="angle_mode_T"><?php echo $text['record_angle']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <select id="angle_mode_T" name="angle_mode_T" style="width: 59%;height: 25px;margin: 5px;border-radius: 0.25rem;text-align: left;padding-left: 5px;font-weight: 400;line-height: 1.5;color: #212529;background-color: #fff;background-clip: padding-box;border: 1px solid #ced4da;" >
                                            <option value="0"><?php echo $text['skip']; ?></option>
                                            <option value="1" selected>+</option>
                                            <option value="2">-</option>
                                        </select>
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="slope_T"><?php echo $text['Acceleration_Slope']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="slope_T" name="slope_T" size="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?><span id="slope_range_T"> 200 - 2000</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['Interrupt_Alarm']; ?>:</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.8; vertical-align: middle" id="Interrupt_OFF_T" name="Interrupt_Alarm_T" value="0" type="radio">
                                        <label for="Interrupt_OFF_T"><?php echo $text['switch_off']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.8; vertical-align: middle" id="Interrupt_ON_T" name="Interrupt_Alarm_T" value="1" type="radio">
                                        <label for="Interrupt_ON_T"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                            </table>
                          </form>
                        </div>
                    </div>
                </div>

                <div id="Angle" class="w3-container target">
                    <div class="scrollbar-modal" id="style-angle">
                        <div class="force-overflow-modal">
                            <table  id="Targer_Angle_Table" class="w3-large w3-padding">
                                <tr>
                                    <td width= "50%">
                                        <label for=""><?php echo $text['seq_id']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control"  size="6" value="<?php echo $data['sequence_id'];?>" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Step_ID_Angle"><?php echo $text['step_id']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_ID_Angle" name="Step_ID_Angle" size="6" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Step_Name_Angle"><?php echo $text['step_name']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_Name_Angle" name="Step_Name_Angle" oninput="validateInput_advancedstep_name('Step_Name_Angle')" size="10">
                                        <div class="invalid-feedback"><?php echo $error_message['step_name']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['direction']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.5; vertical-align: middle" id="Direction_CW_A" name="Direction_Option_A" value="0" type="radio">
                                        <label for="Direction_CW_A"><?php echo $text['CW']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.5; vertical-align: middle" id="Direction_CCW_A" name="Direction_Option_A" value="1" type="radio">
                                        <label for="Direction_CCW_A"><?php echo $text['CCW']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="RPM_A"><?php echo $text['Run_Down_Speed']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="RPM_A" name="RPM_A" size="5"> <?php echo $text['max_rpm'];?> <?php echo $data['tool_info']['tool_maxrpm'];?>
                                        <div class="invalid-feedback"><?php echo $error_message['Run_Down_Speed']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Delay_Time_A"><?php echo $text['delay_time']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Delay_Time_A" name="Delay_Time_A" size="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Delay_Time']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Target_Angle"><?php echo $text['Target_Angle']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Target_Angle" name="Target_Angle" size="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Target_Angle']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $text['Monitor_Mode']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_Window_A" name="Monitor_Option_A" value="0" type="radio">
                                        <label for="Monitor_Window_A"><?php echo $text['Window']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.5; vertical-align: middle" id="Monitor_HiLow_A" name="Monitor_Option_A" value="1" type="radio">
                                        <label for="Monitor_HiLow_A"><?php echo $text['Hi-Lo']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Torque_Window_A_tr">
                                    <td>
                                        <label ><?php echo $text['Torque_Window']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Torque_Window_Add_A" name="Torque_Window_Add_A" size="2">
                                        <label>&#43;&#8725;&#8722;</label>
                                        <input style="font-size:16px; height:25px" class="form-control" id="Torque_Window_Subtraction_A" name="Torque_Window_Subtraction_A" size="2">
                                        <div class="invalid-feedback"><?php echo $error_message['Torque_Window_Add']; ?></div>
                                        <div class="invalid-feedback delta_alert"><?php echo $error_message['Torque_Window_Subtraction'].$data['delta']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Angle_Window_A_tr">
                                    <td>
                                        <label ><?php echo $text['Angle_Window']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Angle_Window_Add_A" name="Angle_Window_Add_A" size="2" disabled>
                                        <label>&#43;&#8725;&#8722;</label>
                                        <input style="font-size:16px; height:25px" class="form-control" id="Angle_Window_Subtraction_A" name="Angle_Window_Subtraction_A" size="2">
                                        <div class="invalid-feedback"><?php echo $error_message['Angle_Window_Add']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Hi_Torque_A_tr">
                                    <td>
                                        <label for="Hi_Torque_A"><?php echo $text['High_Torque']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Hi_Torque_A" name="Hi_Torque_A" size="6">
                                        <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?>
                                        <div class="invalid-feedback"><?php echo $error_message['Hi_Torque']; ?><span id="HQ_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr id="Lo_Torque_A_tr">
                                    <td>
                                        <label for="Lo_Torque_A"><?php echo $text['Low_Torque']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Lo_Torque_A" name="Lo_Torque_A" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Torque']; ?><span id="LQ_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr id="Hi_Angle_A_tr">
                                    <td>
                                        <label for="Hi_Angle_A"><?php echo $text['High_Angle']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Hi_Angle_A" name="Hi_Angle_A" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['High_Angle']; ?><span id="HA_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Lo_Angle_A_tr">
                                    <td>
                                        <label for="Lo_Angle_A"><?php echo $text['Low_Angle']; ?> :</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Lo_Angle_A" name="Lo_Angle_A" size="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?><span id="LA_range"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="angle_mode_A"><?php echo $text['record_angle']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <select id="angle_mode_A" name="angle_mode_A" style="width: 59%;height: 25px;margin: 5px;border-radius: 0.25rem;text-align: left;padding-left: 5px;font-weight: 400;line-height: 1.5;color: #212529;background-color: #fff;background-clip: padding-box;border: 1px solid #ced4da;" >
                                            <option value="0"><?php echo $text['record_angle']; ?></option>
                                            <option value="1" selected>+</option>
                                            <option value="2">-</option>
                                        </select>
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="slope_A"><?php echo $text['Acceleration_Slope']; ?>:</label>
                                    </td>
                                    <td colspan="2">
                                        <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="slope_A" name="slope_A" size="5">
                                        <div class="invalid-feedback">
                                            <?php echo $error_message['Low_Angle']; ?><span id="slope_range_A"> 200 - 2000 </span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label><?php echo $text['Interrupt_Alarm']; ?>:</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.8; vertical-align: middle" id="Interrupt_OFF_A" name="Interrupt_Alarm_A" value="0" type="radio">
                                        <label for="Interrupt_OFF_A">
                                            <?php echo $text['switch_off']; ?></label>
                                    </td>
                                    <td style="text-align: left;">
                                        <input style="zoom:1.8; vertical-align: middle" id="Interrupt_ON_A" name="Interrupt_Alarm_A" value="1" type="radio">
                                        <label for="Interrupt_ON_A">
                                            <?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="Time" class="w3-container target">
                    <table  id="Targer_Time_Table" class="w3-large w3-padding">
                        <tr>
                            <td width= "50%">
                                <label for=""><?php echo $text['seq_id']; ?> :</label>
                            </td>
                            <td width= "50%">
                                <input style="font-size:16px; height:25px; margin:5px" class="form-control"  size="5" value="<?php echo $data['sequence_id'];?>" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td width= "50%">
                                <label for="Step_ID_Time"><?php echo $text['step_id']; ?> :</label>
                            </td>
                            <td width= "50%">
                                <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_ID_Time" name="Step_ID_Time" size="5" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Step_Name_Time"><?php echo $text['step_name']; ?> :</label>
                            </td>
                            <td>
                                <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Step_Name_Time" name="Step_Name_Time" oninput="validateInput_advancedstep_name('Step_Name_Time')" size="10">
                                <div class="invalid-feedback"><?php echo $error_message['step_name']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Delay_Time"><?php echo $text['delay_time']; ?> :</label>
                            </td>
                            <td>
                                <input style="font-size:16px; height:25px; margin:5px" class="form-control" id="Delay_Time" name="Delay_Time" size="5">
                                <div class="invalid-feedback"><?php echo $error_message['Delay_Time']; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="new_step_save" onclick="new_step_save()"><?php echo $text['save']; ?></button>
                    <button type="button" class="btn btn-secondary"  onclick="document.getElementById('StepModal').style.display='none'" ><?php echo $text['close']; ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy Modal -->
    <div class="modal fade" id="CopySeq" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CopySeqLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content w3-animate-zoom" style="width: 550px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CopySeqLabel"><?php echo $text['copy_step']; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="copy_step_form">
                        <div for="from_step_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_from']; ?></div>
                        <div style="padding-left: 10px;">
                            <div class="row">
                                <div for="from_step_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['step_id']; ?>：</div>
                                <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                    <input type="number" class="form-control" id="from_step_id" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div for="from_step_name" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['step_name']; ?>：</div>
                                <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                    <input type="text" class="form-control" id="from_step_name" disabled>
                                </div>
                            </div>
                        </div>

                        <div for="to_step_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_to']; ?></div>
                        <div style="padding-left: 10px;">
                            <div class="row">
                                <div for="to_step_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['step_id']; ?>：</div>
                                <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                    <input type="number" class="form-control" id="to_step_id" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div for="to_step_name" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['step_name']; ?>：</div>
                                <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                    <input type="text" class="form-control" id="to_step_name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="copy_step_save" onclick="copy_step_save()"><?php echo $text['save']; ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $text['close']; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function OpenTarget(evt, targetName) { //換頁
      var i, x, tablinks;
      x = document.getElementsByClassName("target");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
        tablinks[i].classList.remove("w3-teal");
      }
      document.getElementById(targetName).style.display = "block";
      evt.currentTarget.classList.add("w3-teal");
    }

    $(document).ready(function () {
        document.getElementsByClassName("tablink")[0].click();

        var modal = document.getElementById('StepNew');
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        const job_id = $("#job_id").val();
        let table = $('#Table_Step').DataTable({
            // paging: false,
            searching: false,
            bInfo : false,
            "ordering": false,
            // "bPaginate": false,
            "dom": "frti",
            "pageLength": 14,
            columnDefs: [
                {
                    targets: [0,1,2,3,4],
                }
              ]
            });
        $('#Table_Step tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        let data = table.rows().data();
        let page_info = table.page.info();

        $('#RecordCnt').val(data.length);
        $('#CurrentPage').val(page_info.page + 1);
        $( "input[name='TotalPage']" ).val( page_info.pages);

    });

    function crud_job(argument) {

        const job_id = $("#job_id").val();
        const seq_id = $("#sequence_id").val();
        let step_id;
        try {
          step_id = document.querySelector("#Table_Step tr.selected").childNodes[0].textContent;//取得第一欄的值step_id
        } catch (error) { 
          step_id = null; /* 任意默认值都可以被使用 */
        };
        try { 
          step_name = document.querySelector("#Table_Step tr.selected").childNodes[1].textContent;//取得第一欄的值step_name
        } catch (error) { 
          step_name = null; /* 任意默认值都可以被使用 */
        };

        
        if(argument == 'new'){
            new_advancedstep(job_id,seq_id);
        }
        if(argument == 'del' && step_id != null){
            delete_step(job_id,seq_id,step_id);
        }
        if(argument == 'edit' && step_id != null){
            edit_advancedstep(job_id,seq_id,step_id);
        }
        if(argument == 'copy' && step_id != null){
            copy_step(job_id,seq_id,step_id,step_name);
        }

    }
    
    function change_page(argument) {
        let table = $('#Table_Step').DataTable();
        table.page( argument ).draw( 'page' );
        let page_info = table.page.info();
        $('#CurrentPage').val(page_info.page + 1);
    }

    //new step 按下new step button
    function new_advancedstep(job_id,seq_id) {
        // $('input:checkbox').removeAttr('checked');
        // var event = new Event('change');
        clearInvalidClass();
        $("#modal_title").text('<?php echo $text['new_step']; ?>');
        

        //帶入預設值
        // torque tab
        $("#Target_Torque").val(0.5);
        $("input[name='Direction_Option_T'][value='0']").prop("checked", true);
        $("input[name=Monitor_Angle_Option][value='0']").attr('checked',true);
        $("input[name=Over_Ang_Stop_Option][value='0']").attr('checked',true);
        $("input[name=Monitor_Option][value='1']").attr('checked',true);
        $("#RPM").val(document.getElementById('tool_maxrpm').value);
        $("#Joint_OffSet_Direction").val(0);
        $("#Joint_OffSet").val(0);
        $("#Torque_Window_Add").val(0.5);
        $("#Torque_Window_Subtraction").val(0.05);
        $("#Angle_Window_Add").val(1800);
        $("#Angle_Window_Subtraction").val(360);
        $("#Hi_Torque").val(document.getElementById('tool_mintorque').value);
        $("#Lo_Torque").val(0.0);
        $("#Hi_Angle").val(30600);
        $("#Lo_Angle").val(0);
        $("#Delay_Time_T").val(0);
        $("#slope_T").val(2000);
        $("input[name=Interrupt_Alarm_T][value='1']").attr('checked',true);
        //觸發change event 調整版面
        var event = new Event('change');
        var radio1 = document.querySelector('input[name="Monitor_Option"][value="1"]');
        var radio2 = document.querySelector('input[name="Monitor_Angle_Option"][value="0"]');
        var radio3 = document.querySelector('input[name="Over_Ang_Stop_Option"][value="0"]');
        // radio1.checked = true;
        radio1.dispatchEvent(event);
        radio2.dispatchEvent(event);
        radio3.dispatchEvent(event);



        // angle tab
        $("#Target_Angle").val(1800);
        $("input[name='Direction_Option_A'][value='0']").prop("checked", true);
        $("input[name=Monitor_Option_A][value='1']").attr('checked',true);
        $("#RPM_A").val(document.getElementById('tool_maxrpm').value);
        $("#Torque_Window_Add_A").val(0.5);
        $("#Torque_Window_Subtraction_A").val(0.05);
        $("#Angle_Window_Add_A").val(1800);
        $("#Angle_Window_Subtraction_A").val(360);
        $("#Hi_Torque_A").val(document.getElementById('tool_mintorque').value);
        $("#Lo_Torque_A").val(0.0);
        $("#Hi_Angle_A").val(30600);
        $("#Lo_Angle_A").val(0);
        $("#Delay_Time_A").val(0);
        $("#slope_A").val(2000);
        $("input[name=Interrupt_Alarm_A][value='1']").attr('checked',true);
        var radio4 = document.querySelector('input[name="Monitor_Option_A"][value="1"]');
        radio4.dispatchEvent(event);

        // time tab
        $("#Delay_Time").val(0.5);

        // body...

        let step_id = get_step_id_normal(job_id,seq_id);
        // StepModalLabel
        $("#StepModalLabel").text('New Step');
        // console.log(step_id);
        // console.log(seq_id);
        $("#Step_ID_Torque").val(step_id); //set job id
        $("#Step_ID_Angle").val(step_id); //set job id
        $("#Step_ID_Time").val(step_id); //set job id
        //
        $('#StepModal').show();


    }

    //new job 按下save鍵
    function new_step_save(){
        let Torque_div = document.getElementById("Torque").style.display;
        let Angle_div = document.getElementById("Angle").style.display;
        let Time_div = document.getElementById("Time").style.display;
        let target_type = 'torque';

        if(Torque_div == 'block'){
            target_type = 2;
        }else if(Angle_div == 'block'){
            target_type = 1;
        }else if(Time_div == 'block'){
            target_type = 3;
        }

        $('#new_step_save').prop('disabled', true);

        let monitoringangle = 0;
        if ($('input[name=Monitor_Angle_Option]:checked').val() == 1){
            if ($('input[name=Over_Ang_Stop_Option]:checked').val() == 1){
                monitoringangle = 1;
            }else{
                monitoringangle = 2;
            }
        }

        let result =  form_advancedstep_validate(target_type);

        //沒用到的參數回歸預設值
        step_targetangle: $("#Target_Angle").val();
        step_targettorque: $("#Target_Torque").val();
        step_delayttime: $("#Delay_Time").val();
        step_offsetdirection: $('#Joint_OffSet_Direction').val();
        step_torque_jointoffset: $("#Joint_OffSet").val();
        step_monitoringangle: monitoringangle;


        if(result){
            //沒用到的參數回歸預設值
            return_to_default(target_type);

            formData = {
                job_id: $("#job_id").val(),
                sequence_id: $("#sequence_id").val(),
                sequence_name: $("#sequence_name").val(),
                step_id: $("#Step_ID_Torque").val(), // new的時候都一樣 所以只抓Step_ID_Torque就可以了
                step_targetangle: $("#Target_Angle").val(),
                step_targettorque: $("#Target_Torque").val(),
                step_delayttime: $("#Delay_Time").val(),
                step_offsetdirection: $('#Joint_OffSet_Direction').val(),
                step_torque_jointoffset: $("#Joint_OffSet").val(),
                step_monitoringangle: monitoringangle,
                step_targettype: target_type,
            };

            if(target_type == 2){
                formData.step_name = $("#Step_Name_Torque").val();
                formData.step_tooldirection = $('input[name=Direction_Option_T]:checked').val();
                formData.step_rpm = $("#RPM").val();
                formData.step_monitoringmode = $("input[name=Monitor_Option]:checked").val();
                formData.step_torwin_target = $("#Torque_Window_Add").val();
                formData.step_torquewindow = $("#Torque_Window_Subtraction").val();
                formData.step_angwin_target = $("#Angle_Window_Add").val();
                formData.step_anglewindow = $("#Angle_Window_Subtraction").val();
                formData.step_hightorque = $("#Hi_Torque").val();
                formData.step_lowtorque = $("#Lo_Torque").val();
                formData.step_highangle = $("#Hi_Angle").val();
                formData.step_lowangle = $("#Lo_Angle").val();
                formData.step_delayttime = $("#Delay_Time_T").val();
                formData.step_anglemode = $("#angle_mode_T").val();
                formData.step_slope = $("#slope_T").val();
                formData.step_pnf = $("input[name=Interrupt_Alarm_T]:checked").val();
            }

            if(target_type == 1){
                formData.step_name = $("#Step_Name_Angle").val();
                formData.step_tooldirection = $('input[name=Direction_Option_A]:checked').val();
                formData.step_rpm = $("#RPM_A").val();
                formData.step_monitoringmode = $("input[name=Monitor_Option_A]:checked").val();
                formData.step_torwin_target = $("#Torque_Window_Add_A").val();
                formData.step_torquewindow = $("#Torque_Window_Subtraction_A").val();
                formData.step_angwin_target = $("#Angle_Window_Add_A").val();
                formData.step_anglewindow = $("#Angle_Window_Subtraction_A").val();
                formData.step_hightorque = $("#Hi_Torque_A").val();
                formData.step_lowtorque = $("#Lo_Torque_A").val();
                formData.step_highangle = $("#Hi_Angle_A").val();
                formData.step_lowangle = $("#Lo_Angle_A").val();
                formData.step_delayttime = $("#Delay_Time_A").val();
                formData.step_anglemode = $("#angle_mode_A").val();
                formData.step_slope = $("#slope_A").val();
                formData.step_pnf = $("input[name=Interrupt_Alarm_A]:checked").val();
            }

            if(target_type == 3){
                formData.step_name = $("#Step_Name_Time").val();
                formData.step_tooldirection = $('input[name=Direction_Option_T]:checked').val();
                formData.step_rpm = $("#RPM").val();
                formData.step_monitoringmode = $("input[name=Monitor_Option]:checked").val();
                formData.step_torwin_target = $("#Torque_Window_Add").val();
                formData.step_torquewindow = $("#Torque_Window_Subtraction").val();
                formData.step_angwin_target = $("#Angle_Window_Add").val();
                formData.step_anglewindow = $("#Angle_Window_Add").val();
                formData.step_hightorque = $("#Hi_Torque").val();
                formData.step_lowtorque = $("#Lo_Torque").val();
                formData.step_highangle = $("#Hi_Angle").val();
                formData.step_lowangle = $("#Lo_Angle").val();
            }

            // console.log(formData);

            $.ajax({
              type: "POST",
              url: "?url=Advancedsteps/create_step",
              data: formData,
              dataType: "json",
              encode: true,
              beforeSend: function() {
                $('#overlay').removeClass('hidden');
              },
            }).done(function (data) {//成功且有回傳值才會執行
              // console.log(data);
              $('#overlay').addClass('hidden');
              if(data['error_message'] != ''){
                alert(data['error_message']);   
              }else{
                location.reload();
              }
              $('#new_step_save').prop('disabled', false);
            });
        }else{
            $('#new_step_save').prop('disabled', false);    
        }
        
    }

    //validate form
    function form_advancedstep_validate(target_type) {   
        //torque parameter   
        let Target_Torque = document.getElementById("Target_Torque");
        let Hi_Torque = document.getElementById("Hi_Torque");
        let Low_Torque = document.getElementById("Lo_Torque");
        let Joint_OffSet_Direction = document.getElementById("Joint_OffSet_Direction");

        let Target_Angle_A = document.getElementById("Target_Angle");
        let Hi_Angle_A = document.getElementById("Hi_Angle_A");
        let Low_Angle_A = document.getElementById("Lo_Angle_A");
        let Hi_Torque_A = document.getElementById("Hi_Torque_A");
        let Low_Torque_A = document.getElementById("Lo_Torque_A");


        let Angle_Window_Add = document.getElementById("Angle_Window_Add");
        let Hi_Angle = document.getElementById("Hi_Angle");
        let Torque_Window_Add = document.getElementById("Torque_Window_Add");
        let Torque_Window_Subtraction = document.getElementById("Torque_Window_Subtraction");


        let Tool_Max_Torque = parseFloat(document.getElementById('tool_maxtorque').value);
        let Tool_Min_Torque = parseFloat(document.getElementById('tool_mintorque').value);
        let Tool_Max_RPM = parseFloat(document.getElementById('tool_maxrpm').value);
        let Tool_Min_RPM = parseFloat(document.getElementById('tool_minrpm').value);
        let Target_Torque_value = parseFloat(Target_Torque.value);
        let Torque_Unit = document.getElementById("torque_unit").value;
        let delta = document.getElementById('delta').value;
        
        //target_type 1:angle 2:torque 3:time
        if(target_type == 2){//torque
            let Monitor_Option = $('input[name=Monitor_Option]:checked').val()
            if(Monitor_Option == 0){
                Hi_Torque.value = Number.parseFloat(Tool_Max_Torque) + Number.parseFloat(delta);
                Low_Torque.value = 0;
            }else{
                Torque_Window_Subtraction.value = delta;
            }

            let Angle_Window_Subtraction_limit = Math.min(Angle_Window_Add.value, (30600-Angle_Window_Add.value) );
            let Torque_Window_Subtraction_limit = Math.min(Torque_Window_Add.value, (Tool_Max_Torque-Torque_Window_Add.value) );

            let HQ_range = '';
            let LQ_range = '';
            let HA_range = '1 - 30600';
            let LA_range = '0 - ' + Number(Hi_Angle.value - 1);

            if( Torque_Unit == 0 ){
                HQ_range = Number.parseFloat( parseFloat(Target_Torque_value) + parseFloat(delta) ).toFixed(4) +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4);
                LQ_range = '0.0 - '+Number.parseFloat( parseFloat(Target_Torque_value) - parseFloat(delta) ).toFixed(4);
            }else if( Torque_Unit == 1 ){
                HQ_range = Number.parseFloat( parseFloat(Target_Torque_value) + parseFloat(delta) ).toFixed(3) +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(3);
                LQ_range = '0.0 - '+Number.parseFloat( parseFloat(Target_Torque_value) - parseFloat(delta) ).toFixed(3);
            }else{
                HQ_range = Number.parseFloat( parseFloat(Target_Torque_value) + parseFloat(delta) ).toFixed(2) +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(2);
                LQ_range = '0.0 - '+Number.parseFloat( parseFloat(Target_Torque_value) - parseFloat(delta) ).toFixed(2);
            }
            document.getElementById('HQ_range').textContent = HQ_range;
            document.getElementById('LQ_range').textContent = LQ_range;
            document.getElementById('Offset_range').textContent = '-'+Target_Torque_value+' ~ +'+ parseFloat(Tool_Max_Torque*1.1 - Target_Torque_value).toFixed(2);

            if( Hi_Angle.value == ""){
                LA_range = '0 - NaN';
            }

            document.getElementById('HA_range').textContent = HA_range;
            document.getElementById('LA_range').textContent = LA_range;

            var inputs = [
                //torque
                { id: 'Step_Name_Torque', pattern: /^[a-zA-Z0-9\u4E00-\u9FA5\-]+$/, min: null, max: null },
                { id: 'RPM', pattern: /^\d{0,4}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Target_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: Tool_Min_Torque, max: Tool_Max_Torque },
                { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value }, //後面調整
                { id: 'Hi_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: Number.parseFloat( parseFloat(Target_Torque_value) + parseFloat(delta) ).toFixed(4), max: parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Lo_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Number.parseFloat( parseFloat(Target_Torque_value) - parseFloat(delta) ).toFixed(4) },
                { id: 'Hi_Angle', pattern: /^\d{1,5}$/, min: 1, max: 30600 },
                { id: 'Lo_Angle', pattern: /^\d{1,6}$/, min: 0, max: Hi_Angle.value-1 },
                { id: 'Torque_Window_Add', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: null, max: null },
                { id: 'Torque_Window_Subtraction', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: delta, max: parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Angle_Window_Add', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 1, max: 30600 },
                { id: 'Angle_Window_Subtraction', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: 30599 },    
                { id: 'Delay_Time_T', pattern: /^\d{1,2}(\.\d{1})?$/, min: 0.0, max: 10 },            
                { id: 'slope_T', pattern: /^\d{0,4}$/, min: 200, max: 2000 },
            ];

            //join offset要另外判斷
            if(Joint_OffSet_Direction.value == '1'){
                inputs[3] = { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value };
            }else if(Joint_OffSet_Direction.value == '0'){
                inputs[3] = { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: parseFloat(Tool_Max_Torque*1.1 - Target_Torque_value).toFixed(4) };
            }

        }

        if(target_type == 1){// angle
            
            let Hi_Torque_A_value = parseFloat(document.getElementById('Hi_Torque_A').value);
            let Lo_Torque_A_value = parseFloat(document.getElementById('Lo_Torque_A').value);
            let Angle_Window_Subtraction_A = document.getElementById("Angle_Window_Subtraction_A");

            let Monitor_Option_A = $('input[name=Monitor_Option_A]:checked').val()
            if(Monitor_Option_A == 0){
                // Hi_Angle_A.value = 30600;
                Hi_Torque_A.value = Number.parseFloat(Tool_Max_Torque).toFixed(4);
                Lo_Torque_A.value = 0;
                Lo_Angle_A.value = 0;
            }else{
                Torque_Window_Add_A.value = Number.parseFloat(Tool_Max_Torque).toFixed(4);
                Torque_Window_Subtraction_A.value = delta;
                Angle_Window_Subtraction_A.value = 360;
            }

            let HQ_range_A = '';
            let LQ_range_A = '';
            let HA_range = '';
            let LA_range = '';
            if( Torque_Unit == 0 ){
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta) ).toFixed(4);
            }else if( Torque_Unit == 1 ){
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(3);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta) ).toFixed(3);
            }else{
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(2);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta) ).toFixed(2);
            }

            if(Target_Angle_A.value == ''){
                HA_range = 'NaN - 30600';
                LA_range = '0 - NaN';
            }else{
                HA_range = parseFloat(Target_Angle_A.value-1) +' - 30600';
                LA_range = '0 - ' + Number.parseFloat(parseFloat(Target_Angle_A.value-1));
            }

            document.getElementById('HQ_range_A').textContent = HQ_range_A;
            document.getElementById('LQ_range_A').textContent = LQ_range_A;
            document.getElementById('HA_range').textContent = HA_range;
            document.getElementById('LA_range').textContent = LA_range;

            var inputs = [
                //angle
                { id: 'Step_Name_Angle', pattern: /^[a-zA-Z0-9\u4E00-\u9FA5\-]+$/, min: null, max: null },
                { id: 'RPM_A', pattern: /^\d{0,4}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Delay_Time_A', pattern: /^\d{1,2}(\.\d{1})?$/, min: 0, max: 10 },
                { id: 'Target_Angle', pattern: /^\d{0,5}?$/, min: 1, max: 30600 },
                { id: 'Torque_Window_Add_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: null, max: Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Torque_Window_Subtraction_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: delta, max: Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Angle_Window_Add_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: null, max: null },
                { id: 'Angle_Window_Subtraction_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 1, max: 30600 },
                { id: 'Hi_Angle_A', pattern: /^\d{1,5}$/, min: Target_Angle_A.value, max: 30600 },
                { id: 'Lo_Angle_A', pattern: /^\d{1,6}$/, min: 0, max: Target_Angle_A.value },
                { id: 'Hi_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Lo_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: (Hi_Torque_A.value - delta).toFixed(4) },
                { id: 'slope_A', pattern: /^\d{0,4}$/, min: 200, max: 2000 },            
            ];
        }

        if(target_type == 3){
            var inputs = [
                //time
                { id: 'Step_Name_Time', pattern: /^[a-zA-Z0-9\u4E00-\u9FA5\-]+$/, min: null, max: null },
                { id: 'Delay_Time', pattern: /^\d{1,2}(\.\d{1})?$/, min: 0.1, max: 10 },
            ];
        }

        var isFormValid = true; // 表单验证状态，默认为通过

        let not_exceed = ['Threshold_Torque', 'Downshift_Torque', 'Downshift_Speed']; //要小於最大值
        let except = ['Torque_Window_Add_A', 'Torque_Window_Subtraction_A', 'Angle_Window_Subtraction_A'
                    , 'Torque_Window_Subtraction', 'Angle_Window_Add', 'Angle_Window_Subtraction']; //要小於最大值

        // console.log(inputs)

        inputs.forEach(function(input) {
            var element = document.getElementById(input.id);
            var value = element.value.trim();

            if( except.includes(input.id)) {
                if (input.id == 'Torque_Window_Add_A' || input.id == 'Torque_Window_Subtraction_A' ) {
                    if( Number(Torque_Window_Add_A.value) + Number(Torque_Window_Subtraction_A.value) > input.max 
                        || Torque_Window_Add_A.value - Torque_Window_Subtraction_A.value < 0  
                        || Torque_Window_Subtraction_A.value < input.min
                        || value === "" ){
                        element.classList.add("is-invalid");
                        isFormValid = false;
                        //if value >= delta 不顯示
                        if(value >= delta){
                            document.getElementsByClassName('delta_alert')[1].style.display = 'none'
                        }else{
                            document.getElementsByClassName('delta_alert')[1].style.display = 'block'
                        }
                    }else{
                        element.classList.remove("is-invalid");
                    }
                }

                if (input.id == 'Angle_Window_Subtraction_A') {
                    // console.log(value);
                    if( Number(Angle_Window_Add_A.value) + Number(Angle_Window_Subtraction_A.value) > input.max 
                        || Angle_Window_Add_A.value - Angle_Window_Subtraction_A.value < 0 
                        || Angle_Window_Subtraction_A.value <= 0 
                        || value === "" ){
                        element.classList.add("is-invalid");
                        isFormValid = false;
                    }else{
                        element.classList.remove("is-invalid");
                    }
                }

                if (input.id == 'Torque_Window_Subtraction' ) {
                    if( Number(Torque_Window_Add.value) + Number(Torque_Window_Subtraction.value) > input.max 
                        || Torque_Window_Add.value - Torque_Window_Subtraction.value < 0  
                        || Torque_Window_Subtraction.value < input.min 
                        || value === "" ){
                        element.classList.add("is-invalid");
                        isFormValid = false;
                        //if value >= delta 不顯示
                        if(value >= delta){
                            document.getElementsByClassName('delta_alert')[0].style.display = 'none'
                        }else{
                            document.getElementsByClassName('delta_alert')[0].style.display = 'block'
                        }
                    }else{
                        element.classList.remove("is-invalid");
                    }
                }

                if (input.id == 'Angle_Window_Add' || input.id == 'Angle_Window_Subtraction' ) {
                    if( Number(Angle_Window_Add.value) + Number(Angle_Window_Subtraction.value) > input.max 
                        || Angle_Window_Add.value - Angle_Window_Subtraction.value < 0  
                        || value === "" ){
                        element.classList.add("is-invalid");
                        isFormValid = false;
                    }else{
                        element.classList.remove("is-invalid");
                    }
                }

                return;
            }

            if (value === "") {
                element.classList.add("is-invalid");
                isFormValid = false;
            } else if (!input.pattern.test(value)) {
                // element.value = "";
                element.classList.add("is-invalid");
                isFormValid = false;
            } else if (input.min !== null && parseFloat(value) < input.min) {
                element.classList.add("is-invalid");
                isFormValid = false;
            } else if (input.max !== null && parseFloat(value) > input.max) {
                element.classList.add("is-invalid");
                isFormValid = false;
            } else {
                element.classList.remove("is-invalid");
            }
        });

        // console.log(isFormValid);

        return isFormValid;
    }

    //回歸預設值
    function return_to_default(target_type) {
        if(target_type == 1){
            let monitor_mode_A = $("input[name=Monitor_Option_A]:checked").val();

            if(monitor_mode_A == 1){
                $("#Torque_Window_Add_A").val(0.5);
                $("#Torque_Window_Subtraction_A").val(0.05);
                $("#Angle_Window_Add_A").val(1800);
                $("#Angle_Window_Subtraction_A").val(360);
            }else{
                $("#Hi_Torque").val(document.getElementById('tool_mintorque').value);
                $("#Lo_Torque").val(0.0);
                $("#Hi_Angle").val(30600);
                $("#Lo_Angle").val(0);
            }

            // torque tab
            $("#Target_Torque").val(document.getElementById('tool_mintorque').value);
            $("input[name='Direction_Option_T'][value='0']").prop("checked", true);
            $("input[name=Monitor_Angle_Option][value='0']").attr('checked',true);
            $("input[name=Over_Ang_Stop_Option][value='0']").attr('checked',true);
            $("input[name=Monitor_Option][value='1']").attr('checked',true);
            $("#RPM").val(document.getElementById('tool_maxrpm').value);
            $("#Joint_OffSet_Direction").val(0);
            $("#Joint_OffSet").val(0);
            $("#Torque_Window_Add").val(0.5);
            $("#Torque_Window_Subtraction").val(0.05);
            $("#Angle_Window_Add").val(1800);
            $("#Angle_Window_Subtraction").val(360);
            $("#Hi_Torque").val(document.getElementById('tool_mintorque').value);
            $("#Lo_Torque").val(0.0);
            $("#Hi_Angle").val(30600);
            $("#Lo_Angle").val(0);
            // time tab
            $("#Delay_Time").val(0.5);
        }
        if(target_type == 2){
            let monitoringangle = 0;
            if ($('input[name=Monitor_Angle_Option]:checked').val() == 1){
                if ($('input[name=Over_Ang_Stop_Option]:checked').val() == 1){
                    monitoringangle = 1;
                }else{
                    monitoringangle = 2;
                }
            }

            let monitor_mode = $("input[name=Monitor_Option]:checked").val();
            let monitor_angle = $("input[name=Monitor_Angle_Option]:checked").val();

            if (monitor_mode == 1) { // Hi-Lo
                //disable name="Torque_Window_Subtraction"
                $("#Torque_Window_Subtraction").prop('disabled', true);
                $("#Torque_Window_tr").hide();
                // $("#Torque_Window_Add").val(0.5);
                $("#Torque_Window_Subtraction").val(0.05);


                //show Hi_Torque tr
                $("#Hi_Torque_tr").show();
                //show Lo_Torque tr
                $("#Lo_Torque_tr").show();

                if(monitor_angle == 1){
                  //show Hi_Angle tr
                  $("#Hi_Angle_tr").show();
                  //show Lo_Angle tr
                  $("#Lo_Angle_tr").show();
                }

              }
              if (monitor_mode == 0) { // Window
                  //undisable name="Torque_Window_Subtraction"
                $("#Torque_Window_Subtraction").prop('disabled', false);
                $("#Torque_Window_tr").show();
                  //hide Hi_Torque tr
                $("#Hi_Torque_tr").hide();
                  //hide Lo_Torque tr
                $("#Lo_Torque_tr").hide();
                  //hide Hi_Angle tr
                $("#Hi_Angle_tr").hide();
                  //hide Lo_Angle tr
                $("#Lo_Angle_tr").hide();
                $("#Hi_Torque").val(document.getElementById('tool_mintorque').value);
                $("#Lo_Torque").val(0.0);
                $("#Hi_Angle").val(30600);
                $("#Lo_Angle").val(0);
                
              }

            // angle tab
            $("#Target_Angle").val(1800);
            $("input[name='Direction_Option_A'][value='0']").prop("checked", true);
            $("input[name=Monitor_Option_A][value='1']").attr('checked',true);
            $("#RPM_A").val(document.getElementById('tool_maxrpm').value);
            $("#Torque_Window_Add_A").val(0.5);
            $("#Torque_Window_Subtraction_A").val(0.05);
            $("#Angle_Window_Add_A").val(1800);
            $("#Angle_Window_Subtraction_A").val(360);
            $("#Hi_Torque_A").val(0.6);
            $("#Lo_Torque_A").val(0.0);
            $("#Hi_Angle_A").val(30600);
            $("#Lo_Angle_A").val(0);
            // time tab
            $("#Delay_Time").val(0.5);
        }
        if(target_type == 3){
            $("#Target_Torque").val(0.5);
            $("input[name='Direction_Option_T'][value='0']").prop("checked", true);
            $("input[name=Monitor_Angle_Option][value='0']").attr('checked',true);
            $("input[name=Over_Ang_Stop_Option][value='0']").attr('checked',true);
            $("input[name=Monitor_Option][value='1']").attr('checked',true);
            $("#RPM").val(document.getElementById('tool_maxrpm').value);
            $("#Joint_OffSet_Direction").val(0);
            $("#Joint_OffSet").val(0);
            $("#Torque_Window_Add").val(0.5);
            $("#Torque_Window_Subtraction").val(0.05);
            $("#Angle_Window_Add").val(1800);
            $("#Angle_Window_Subtraction").val(360);
            $("#Hi_Torque").val(document.getElementById('tool_mintorque').value);
            $("#Lo_Torque").val(0.0);
            $("#Hi_Angle").val(30600);
            $("#Lo_Angle").val(0);
            // angle tab
            $("#Target_Angle").val(1800);
            $("input[name='Direction_Option_A'][value='0']").prop("checked", true);
            $("input[name=Monitor_Option_A][value='1']").attr('checked',true);
            $("#RPM_A").val(document.getElementById('tool_maxrpm').value);
            $("#Torque_Window_Add_A").val(0.5);
            $("#Torque_Window_Subtraction_A").val(0.05);
            $("#Angle_Window_Add_A").val(1800);
            $("#Angle_Window_Subtraction_A").val(360);
            $("#Hi_Torque_A").val(0.6);
            $("#Lo_Torque_A").val(0.0);
            $("#Hi_Angle_A").val(30600);
            $("#Lo_Angle_A").val(0);
        }
    }



    //驗證job name
    function validateInput_advancedstep_name(input_id) {
        const inputElement = document.getElementById(input_id);
        inputElement.addEventListener('input', function(event) {
          let inputValue = event.target.value;
          
          // 移除特殊字符 只留-
          inputValue = inputValue.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\- ]/g, '');
          
          // 限制字符串长度为10个字符
          if (inputValue.length > 10) {
            inputValue = inputValue.slice(0, 10);  // 截断字符串到限制长度
          }
          
          // 更新输入框的值
          event.target.value = inputValue;
        });
    }

    //get job_id
    function get_step_id_normal(job_id,seq_id) {

        $.ajax({
          type: "POST",
          url: "?url=Advancedsteps/get_head_step_id",
          data: {'job_id':job_id,'seq_id':seq_id},
          dataType: "json",
          encode: true,
          async: false,//等待ajax完成
        }).done(function (data) {//成功且有回傳值才會執行
            step_id = data['missing_id'];
        });

        if(step_id >= 8){
            step_id = 8;
        }

        return step_id;
    }

    function edit_advancedstep(job_id,seq_id,step_id){
        $("#modal_title").text('<?php echo $text['edit_step']; ?>');
        clearInvalidClass();

        $.ajax({
          type: "POST",
          url: "?url=Advancedsteps/get_advstep_by_id",
          data: {'job_id':job_id,'seq_id':seq_id,'step_id':step_id},
          dataType: "json",
          encode: true,
          async: false,//等待ajax完成
        }).done(function (res) {//成功且有回傳值才會執行
          // console.log(res);
          
          $('input:checkbox').removeAttr('checked');

          if(res.step_monitoringangle == 0){
            $("input[name=Monitor_Angle_Option][value='0']").attr('checked',true); 
            $("input[name=Over_Ang_Stop_Option][value='0']").attr('checked',true);
          }
          if(res.step_monitoringangle == 1){
            $("input[name=Monitor_Angle_Option][value='1']").attr('checked',true); 
            $("input[name=Over_Ang_Stop_Option][value='1']").attr('checked',true); 
          }
          if(res.step_monitoringangle == 2){
            $("input[name=Monitor_Angle_Option][value='1']").attr('checked',true); 
            $("input[name=Over_Ang_Stop_Option][value='0']").attr('checked',true); 
          }

          $("#Step_ID_Torque").val(res.step_id);
          $("#Step_ID_Angle").val(res.step_id);
          $("#Step_ID_Time").val(res.step_id);

          $("#Step_Name_Torque").val(res.step_name);
          $("#Step_Name_Angle").val(res.step_name);
          $("#Step_Name_Time").val(res.step_name);
          
          $("input[name=Monitor_Option][value='"+res.step_monitoringmode+"']").attr('checked',true); 
          $("input[name=Direction_Option_T][value='"+res.step_tooldirection+"']").attr('checked',true);   
          $("#RPM").val(res.step_rpm);

          $("#Target_Torque").val(res.step_targettorque);
          $("#Target_Angle").val(res.step_targetangle);
          $("#Delay_Time").val(res.step_delayttime);

          // $("#TargetType").val(res.step_targettype);
          $("#Joint_OffSet_Direction").val(res.step_offsetdirection);
          $("#Joint_OffSet").val(res.step_torque_jointoffset);

          $("#Torque_Window_Add").val(res.step_torwin_target);
          $("#Torque_Window_Subtraction").val(res.step_torquewindow);
          $("#Angle_Window_Add").val(res.step_angwin_target);
          $("#Angle_Window_Subtraction").val(res.step_anglewindow);
          $("#Hi_Torque").val(res.step_hightorque);
          $("#Lo_Torque").val(res.step_lowtorque);
          $("#Hi_Angle").val(res.step_highangle);
          $("#Lo_Angle").val(res.step_lowangle);

          //Angle
          $("input[name=Monitor_Option_A][value='"+res.step_monitoringmode+"']").attr('checked',true); 
          $("input[name=Direction_Option_A][value='"+res.step_tooldirection+"']").attr('checked',true); 
          $("#RPM_A").val(res.step_rpm);
          $("#Torque_Window_Add_A").val(res.step_torwin_target);
          $("#Torque_Window_Subtraction_A").val(res.step_torquewindow);
          $("#Angle_Window_Add_A").val(res.step_angwin_target);
          $("#Angle_Window_Subtraction_A").val(res.step_anglewindow);
          $("#Hi_Torque_A").val(res.step_hightorque);
          $("#Lo_Torque_A").val(res.step_lowtorque);
          $("#Hi_Angle_A").val(res.step_highangle);
          $("#Lo_Angle_A").val(res.step_lowangle);

          $("#Delay_Time_T").val(res.step_delayttime);
          $("#Delay_Time_A").val(res.step_delayttime);
          $("#angle_mode_T").val(res.step_angle_mode);
          $("#angle_mode_A").val(res.step_angle_mode);

          $("input[name=Interrupt_Alarm_T][value='"+res.step_pnf_set+"']").attr('checked',true); 
          $("input[name=Interrupt_Alarm_A][value='"+res.step_pnf_set+"']").attr('checked',true); 
          $("#slope_T").val(res.step_slope);
          $("#slope_A").val(res.step_slope);

          // $('#StepModal').modal('toggle');
          //依據res.step_targettype切換tab
          if(res.step_targettype == 2){ document.getElementsByClassName("tablink")[0].click(); }
          if(res.step_targettype == 1){ document.getElementsByClassName("tablink")[1].click(); }
          if(res.step_targettype == 3){ document.getElementsByClassName("tablink")[2].click(); }

          //設定tr開合
          var event = new Event('change');
          var radio1 = document.querySelector('input[name="Monitor_Option"]:checked');
          var radio2 = document.querySelector('input[name="Monitor_Angle_Option"]:checked');
          var radio3 = document.querySelector('input[name="Over_Ang_Stop_Option"]:checked');
          var radio4 = document.querySelector('input[name="Monitor_Option_A"]:checked');
          radio1.dispatchEvent(event);
          radio2.dispatchEvent(event);
          radio3.dispatchEvent(event);
          radio4.dispatchEvent(event);


          $('#StepModal').show();
        });

    }

    function delete_step(job_id,seq_id,step_id) {

        let message = '<?php echo $text['delete_step_confirm_text']; ?>'+step_id;
        Swal.fire({
            title: message,
            showCancelButton: true,
            confirmButtonText: '<?php echo $text['delete_text'];?>',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "?url=Advancedsteps/delete_step_by_id",
                  data: {'job_id':job_id,'seq_id':seq_id,'step_id':step_id},
                  dataType: "json",
                  encode: true,
                  // async: false,//等待ajax完成
                  beforeSend: function() {
                    $('#overlay').removeClass('hidden');
                  },
                }).done(function (res) {//成功且有回傳值才會執行
                    $('#overlay').addClass('hidden');
                    location.reload();
                });
            }
        })

    }

    function copy_step(job_id,seq_id,step_id,step_name){

        let new_step_id = get_step_id_normal(job_id,seq_id);
        $("#from_step_id").val(step_id);
        $("#from_step_name").val(step_name);
        $("#to_step_id").val(new_step_id);
        $('#CopySeq').modal('toggle');

    }

    //new seq 按下save鍵
    function copy_step_save(){
        $('#copy_step_save').prop('disabled', true);
        let confirm = true;
        var formData = {
          from_job_id: $("#job_id").val(),
          from_seq_id: $("#sequence_id").val(),
          from_step_id: $("#from_step_id").val(),
          to_step_id: $("#to_step_id").val(),
          to_step_name: $("#to_step_name").val(),
        };
        // console.log(formData);

        $.ajax({
            type: "POST",
            url: "?url=Advancedsteps/copy_step",
            data: formData,
            dataType: "json",
            encode: true,
            beforeSend: function() {
              $('#overlay').removeClass('hidden');
            },
        }).done(function(data) { //成功且有回傳值才會執行
            // console.log(data);
            $('#overlay').addClass('hidden');
            if(data['error_message'] != ''){
             alert(data['error_message']);
            }else{
             location.reload();  
            }
            if (data == true) {
                $('#copy_step_save').prop('disabled', false);
                location.reload();
            }
        });

    }


    //sequence up down js
    function get_previoussibling(n) {
        x = n.previousSibling;
        while (x.nodeType != 1) {
            x = x.previousSibling;
        }
        return x;
    }

    function get_nextsibling(n) {
        x = n.nextSibling;
        while (x != null && x.nodeType != 1) {
            x = x.nextSibling;
        }
        return x;
    }

    function MoveUp() {
        var table,
            row = this.parentNode;
        var index = this.parentNode.parentNode.rowIndex;

        while (row != null) {
            if (row.nodeName == 'TR') {
                break;
            }
            row = row.parentNode;
        }
        
        table = row.parentNode;
        $(this.parentNode.parentNode).removeClass('selected');//保持up down selected

        if( index > 1 ){
            swap_row(row,'up');
        }else{
            Swal.fire('<?php echo $text['already_top']; ?>');
        }

    }

    function MoveDown() {
        var table,
            row = this.parentNode;
        var index = this.parentNode.parentNode.rowIndex;

        while (row != null) {
            if (row.nodeName == 'TR') {
                break;
            }
            row = row.parentNode;
        }

        table = row.parentNode;
        $(this.parentNode.parentNode).removeClass('selected');//保持up down selected

        if ( index < table.rows.length ){
            swap_row(row,'down');
        }else{
            Swal.fire('<?php echo $text['already_bottom']; ?>');
        }

    }

    //function row swap
    function swap_row(row,direction) {
        let table = row.parentNode;
        let origin_index = row.childNodes[0].textContent;

        if(direction == 'up'){
            pre_row = row.previousSibling;
            pre_index = pre_row.childNodes[0].textContent;
            step_id2 = pre_index;
        }
        if(direction == 'down'){
            next_row = row.nextSibling;
            next_index = next_row.childNodes[0].textContent;
            step_id2 = next_index;
        }

        var formData = {
            job_id: $("#job_id").val(),
            seq_id: $("#sequence_id").val(),
            step_id1: origin_index,
            step_id2: step_id2,
        };

        $.ajax({
          type: "POST",
          url: "?url=Advancedsteps/swap_advancedstep",
          data: formData,
          dataType: "json",
          encode: true,
          beforeSend: function() {
            $('#overlay').removeClass('hidden');
          },
        }).done(function (data) {//成功且有回傳值才會執行
          // console.log(data);
          $('#overlay').addClass('hidden');
          if(data['error_message'] != ''){
            alert(data['error_message']);   
          }else{
            if(direction == 'up'){
                table.insertBefore(row, get_previoussibling(row));
                pre_row.childNodes[0].textContent = origin_index;
                row.childNodes[0].textContent = pre_index;
            }
            if(direction == 'down'){
                table.insertBefore(row, get_nextsibling(get_nextsibling(row)));
                next_row.childNodes[0].textContent = origin_index;
                row.childNodes[0].textContent = next_index;
            }
            // location.reload();   


          }
        });

    }

</script>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs()
    document.getElementById("return").disabled = false;
    document.getElementById("S6").disabled = false; //edit button
    document.getElementById("S2").disabled = false; //previous
    document.getElementById("S7").disabled = false; //next
    document.getElementsByClassName("btn-close")[0].disabled = false;//btn-close

    var buttons = document.getElementsByClassName("button_sequence");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = false;
    }
  });
</script>
<?php } ?>