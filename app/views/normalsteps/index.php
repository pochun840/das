<link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>css/target_torque_angle.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/datatables.min.css">

<script src="<?php echo URLROOT; ?>/js/target_torque_angle.js"></script>
<script src="<?php echo URLROOT; ?>/js/normalstep.js"></script>
<style type="text/css">
    .form-control
    {
        width: auto!important;
        display: initial!important;
    }
    .form-control.is-invalid
    {
        padding-right:inherit!important;
    }
    .is-invalid~.invalid-feedback
    {
        display: inline!important;
    }
.t1{font-size: 17px; margin: 5px 0px; display: flex; align-items: center;}
.t2{font-size: 17px; margin: 5px 0px;}
</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <header>
            <h3><?php echo $text['normal_step']; ?></h3>
        </header>
    </div>

    <div class="main-content">
        <div class="center-content">
            <div class="topnav">
                <div class="row t1">
                    <div class="col-1" style="font-size: 2vmin; padding-left: 3%"><?php echo $text['job_id']; ?> : </div>
                    <div class="col-4 t2">
                    	<input style="height:35px; font-size:18px;text-align: center; background-color: #DDDDDD" type="text" id="job_id" name="job_id" size="10" maxlength="20" value="<?php echo $data['job_id'];?>" disabled>
                    </div>

                    <div class="col t2">
                        <div class="button-column">
                            <button id="bnt1" name="Torque_Display" class="button button3" onclick="FunctionKey('Torque')"><?php echo $text['torque']; ?></button>
                            <button id="bnt2" name="Angle_Display" class="button button3" onclick="FunctionKey('Angle')"><?php echo $text['angle']; ?></button>
                            <button id="return" onclick="history.go(-1);"><?php echo $text['return']; ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="padding: 10px 80px">
            <div id="Manual_Setting">
                <div id="TorqueDisplay">
                    <div class="scrollbar" id="style-torque">
                        <div class="force-overflow">
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label for="Tool_Max_Torque"><?php echo $text['Tool_Max_Torque']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="font-size:15px; height:30px" class="form-control" id="Tool_Max_Torque" name="Tool_Max_Torque" size="10" value="<?php echo $data['tool_info']['tool_maxtorque'];?>" disabled> <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?>
                                        <input style="display: none;"  id="Tool_Min_Torque" name="Tool_Min_Torque" value="<?php echo $data['tool_info']['tool_mintorque'];?>" disabled>
                                        <input style="display: none;"  id="torque_unit" name="torque_unit" value="<?php echo $data['controller_Info']['device_torque_unit']; ?>" disabled>
                                        <input style="display: none;"  id="delta" name="delta" value="<?php echo $data['delta']; ?>" disabled>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Seq_ID"><?php echo $text['seq_id']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Seq_ID" name="Seq_ID" size="10" value="<?php echo $data['noramlstep']['sequence_id'];?>" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Seq_Name"><?php echo $text['seq_name']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Seq_Name" name="Seq_Name" size="10" value="<?php echo $data['noramlstep']['sequence_name'];?>" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Target_Torque"><?php echo $text['Target_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Target_Torque"  name="Target_Torque" size="10" type="text" pattern="\d*" maxlength="6" value="<?php echo $data['noramlstep']['step_targettorque'];?>"> <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?>
                                        <div class="invalid-feedback"><?php echo $error_message['Target_Torque']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Run_Down_Speed"><?php echo $text['Run_Down_Speed']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Run_Down_Speed"  name="Run_Down_Speed" size="10" value="<?php echo $data['noramlstep']['step_rpm'];?>" type="text" pattern="\d*" maxlength="4" >
                                        <label for="tool_maxrpm"><?php echo $text['max_rpm'];?> <?php echo $data['tool_info']['tool_maxrpm'];?></label>
                                        <div class="invalid-feedback"><?php echo $error_message['Run_Down_Speed']; ?></div>
                                        <input type="" id="tool_maxrpm" value="<?php echo $data['tool_info']['tool_maxrpm'];?>" disabled style="display:none;">
                                        <input type="" id="tool_minrpm" value="<?php echo $data['tool_info']['tool_minrpm'];?>" disabled style="display:none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Hi_Torque"><?php echo $text['High_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Hi_Torque" name="Hi_Torque" value="<?php echo $data['noramlstep']['step_hightorque'];?>" size="10" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Hi_Torque']; ?><span id="HQ_range"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Low_Torque"><?php echo $text['Low_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Low_Torque" name="Low_Torque" size="10" value="<?php echo $data['noramlstep']['step_lowtorque'];?>" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Torque']; ?><span id="LQ_range"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Threshold_Type"><?php echo $text['Threshold_Type']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Threshold_Type_Torque" name="Threshold_Type" value="0">
                                        <label for="Threshold_Type_Torque"><?php echo $text['torque']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Threshold_Type_Angle" name="Threshold_Type" value="1">
                                        <label for="Threshold_Type_Angle"><?php echo $text['angle']; ?></label>
                                    </td>
                                </tr>
                                <tr id="tr_threshold_torque">
                                    <td>
                                        <label for="Threshold_Torque"><?php echo $text['Threshold_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Threshold_Torque" name="Threshold_Torque" size="10" value="<?php echo $data['noramlstep']['step_threshold_torque'];?>" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Threshold_Torque']; ?><span id="Threshold_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="tr_threshold_angle">
                                    <td>
                                        <label for="Threshold_Angle"><?php echo $text['Threshold_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Threshold_Angle" name="Threshold_Angle" size="10" value="<?php echo $data['noramlstep']['step_threshold_angle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Threshold_Angle']; ?><span id=""></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Joint_OffSet_Option"><?php echo $text['Joint_Offset']; ?> :</label>
                                    </td>
                                    <td>
                                        <form id="OffSet" action="#">
                                            <select id="Joint_OffSet_Option" style="font-size:16px; height:30px">
                                                <option value="0" selected>+</option>
                                                <option value="1">−</option>
                                            </select>
                                            <input style="font-size:16px; height:35px" class="form-control" id="Joint_OffSet" name="Joint_OffSet" size="4" value="<?php echo $data['noramlstep']['step_torque_jointoffset'];?>" type="text" pattern="\d*" maxlength="6">
                                            <div class="invalid-feedback"><?php echo $error_message['Joint_OffSet']; ?><span id="Offset_range"></span></div>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label ><?php echo $text['Downshift_Enable']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Downshift_Enable_OFF" name="Downshift_Enable" value="0">
                                        <label for="Downshift_Enable_OFF"><?php echo $text['switch_off']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Downshift_Enable_ON" name="Downshift_Enable" value="1">
                                        <label for="Downshift_Enable_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Downshift_Enable_row1">
                                    <td>
                                        <label for="Downshift_Torque"><?php echo $text['Downshift_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Downshift_Torque"  name="Downshift_Torque" size="10" value="<?php echo $data['noramlstep']['step_downshift_torque'];?>" type="text" pattern="\d*" maxlength="6" >
                                        <div class="invalid-feedback"><?php echo $error_message['Downshift_Torque']; ?><span id="DST_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Downshift_Enable_row2">
                                    <td>
                                        <label for="Downshift_Speed"><?php echo $text['Downshift_Speed']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Downshift_Speed"  name="Downshift_Speed" size="10" value="<?php echo $data['noramlstep']['step_downshift_speed'];?>" type="text" pattern="\d*" maxlength="4">
                                        <div class="invalid-feedback"><?php echo $error_message['Downshift_Speed']; ?><span id="DSS_range"></span></div>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label><?php echo $text['Monitor_Angle']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Monitoring_Angle_OFF" name="Monitoring_Angle" value="0">
                                        <label for="Monitoring_Angle_OFF"><?php echo $text['switch_off']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Monitoring_Angle_ON" name="Monitoring_Angle" value="1">
                                        <label for="Monitoring_Angle_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Monitoring_Angle_row1">
                                    <td>
                                        <label ><?php echo $text['Over_Angle_Stop']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Over_Angle_Stop_OFF" name="Over_Angle_Stop" value="0">
                                        <label for="Over_Angle_Stop_OFF"><?php echo $text['switch_off']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Over_Angle_Stop_ON" name="Over_Angle_Stop" value="1">
                                        <label for="Over_Angle_Stop_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Monitoring_Angle_row2">
                                    <td>
                                        <label for="High_Angle"><?php echo $text['High_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="High_Angle"  name="High_Angle" size="10" value="<?php echo $data['noramlstep']['step_highangle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['High_Angle']; ?><span id="HA_range"></span></div>
                                    </td>
                                </tr>
                                <tr id="Monitoring_Angle_row3">
                                    <td>
                                        <label for="Low_Angle"><?php echo $text['Low_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Low_Angle"  name="Low_Angle" size="10" value="<?php echo $data['noramlstep']['step_lowangle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?><span id="LA_range"></span></div>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label ><?php echo $text['Pre_Run']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Pre_Run_Unfasten_OFF" name="Pre_Run_Unfasten" value="0">
                                        <label for="Pre_Run_Unfasten_OFF"><?php echo $text['switch_off']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Pre_Run_Unfasten_ON" name="Pre_Run_Unfasten" value="1">
                                        <label for="Pre_Run_Unfasten_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Pre_Run_Unfasten_row1">
                                    <td>
                                        <label for="Pre_Run_RPM"><?php echo $text['Pre_Run_RPM']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Pre_Run_RPM"  name="Pre_Run_RPM" size="10" value="<?php echo $data['noramlstep']['step_prr_rpm'];?>" type="text" pattern="\d*" maxlength="4">
                                        <div class="invalid-feedback"><?php echo $error_message['Pre_Run_RPM']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Pre_Run_Unfasten_row2">
                                    <td>
                                        <label for="Pre_Run_Angle"><?php echo $text['Pre_Run_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Pre_Run_Angle"  name="Pre_Run_Angle" size="10" value="<?php echo $data['noramlstep']['step_prr_angle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Pre_Run_Angle']; ?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="AngleDisplay">
                    <div class="scrollbar" id="style-angle">
                        <div class="force-overflow">
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label for="Tool_Max_Torque_A"><?php echo $text['Tool_Max_Torque']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="font-size:15px; height:30px" class="form-control" id="Tool_Max_Torque_A" name="Tool_Max_Torque_A" size="10" value="<?php echo $data['tool_info']['tool_maxtorque'];?>" disabled> <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Seq_ID_A"><?php echo $text['seq_id']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Seq_ID_A"  name="Seq_ID_A" size="10" value="<?php echo $data['noramlstep']['sequence_id'];?>" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Seq_Name_A"><?php echo $text['seq_name']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Seq_Name_A" name="Seq_Name_A" size="10" value="<?php echo $data['noramlstep']['sequence_name'];?>" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Target_Angle_A"><?php echo $text['Target_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Target_Angle_A"  name="Target_Angle_A" size="10" value="<?php echo $data['noramlstep']['step_targetangle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Target_Angle']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Run_Down_Speed_A"><?php echo $text['Run_Down_Speed']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Run_Down_Speed_A"  name="Run_Down_Speed_A" size="10" value="<?php echo $data['noramlstep']['step_rpm'];?>" type="text" pattern="\d*" maxlength="4"> <?php echo $text['max_rpm'];?> <?php echo $data['tool_info']['tool_maxrpm'];?>
                                        <div class="invalid-feedback"><?php echo $error_message['Run_Down_Speed']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Threshold_Type_A"><?php echo $text['Threshold_Type']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Threshold_Type_A_Torque" name="Threshold_Type_A" value="0">
                                        <label for="Threshold_Type_A_Torque"><?php echo $text['torque']; ?></label>&nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Threshold_Type_A_Angle" name="Threshold_Type_A" value="1">
                                        <label for="Threshold_Type_A_Angle"><?php echo $text['angle']; ?></label>
                                    </td>
                                </tr>
                                <tr id="tr_threshold_torque_A">
                                    <td>
                                        <label for="Threshold_Torque_A"><?php echo $text['Threshold_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Threshold_Torque_A"  name="Threshold_Torque_A" size="10" value="<?php echo $data['noramlstep']['step_threshold_torque'];?>" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Threshold_Torque_A']; ?><span id="THS_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr id="tr_threshold_angle_A">
                                    <td>
                                        <label for="Threshold_Angle_A"><?php echo $text['Threshold_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Threshold_Angle_A" name="Threshold_Angle_A" size="10" value="<?php echo $data['noramlstep']['step_threshold_angle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Threshold_Angle']; ?><span id=""></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Hi_Angle_A"><?php echo $text['High_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Hi_Angle_A"  name="Hi_Angle_A" size="10" value="<?php echo $data['noramlstep']['step_highangle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['High_Angle']; ?><span id="HA_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Low_Angle_A"><?php echo $text['Low_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Low_Angle_A"  name="Low_Angle_A" size="10" value="<?php echo $data['noramlstep']['step_lowangle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Angle']; ?><span id="LA_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Hi_Torque_A"><?php echo $text['High_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Hi_Torque_A"  name="Hi_Torque_A" size="10" value="<?php echo $data['noramlstep']['step_hightorque'];?>" type="text" pattern="\d*" maxlength="6"> <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?>
                                        <div class="invalid-feedback"><?php echo $error_message['Hi_Torque']; ?><span id="HQ_range_A"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Low_Torque_A"><?php echo $text['Low_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control"id="Low_Torque_A"  name="Low_Torque_A" size="10" value="<?php echo $data['noramlstep']['step_lowtorque'];?>" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Low_Torque']; ?><span id="LQ_range_A"></span></div>
                                    </td>
                                </tr>
                            </table>
                            <table  class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label ><?php echo $text['Downshift_Enable']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Downshift_Enable_A_OFF" name="Downshift_Enable_A" value="0">
                                        <label for="Downshift_Enable_A_OFF"><?php echo $text['switch_off']; ?></label> &nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Downshift_Enable_A_ON" name="Downshift_Enable_A" value="1">
                                        <label for="Downshift_Enable_A_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Downshift_Enable_A_row1">
                                    <td>
                                        <label for="Downshift_Torque_A"><?php echo $text['Downshift_Torque']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Downshift_Torque_A"  name="Downshift_Torque_A" size="10" value="<?php echo $data['noramlstep']['step_downshift_torque'];?>" type="text" pattern="\d*" maxlength="6">
                                        <div class="invalid-feedback"><?php echo $error_message['Downshift_Torque_A']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Downshift_Enable_A_row2">
                                    <td>
                                        <label for="Downshift_Speed_A"><?php echo $text['Downshift_Speed']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Downshift_Speed_A"  name="Downshift_Speed_A" size="10" value="<?php echo $data['noramlstep']['step_downshift_speed'];?>" type="text" pattern="\d*" maxlength="4">
                                        <div class="invalid-feedback"><?php echo $error_message['Downshift_Speed']; ?></div>
                                    </td>
                                </tr>
                            </table>
                            <table  class="table table-hover">
                                <tr>
                                    <td width="50%">
                                        <label ><?php echo $text['Pre_Run']; ?> :</label>
                                    </td>
                                    <td width="50%">
                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Pre_Run_Unfasten_A_OFF" name="Pre_Run_Unfasten_A" value="0">
                                        <label for="Pre_Run_Unfasten_A_OFF"><?php echo $text['switch_off']; ?></label> &nbsp;&nbsp;&nbsp;

                                        <input style="zoom:1.8; vertical-align: middle" type="radio" id="Pre_Run_Unfasten_A_ON" name="Pre_Run_Unfasten_A" value="1">
                                        <label for="Pre_Run_Unfasten_A_ON"><?php echo $text['switch_on']; ?></label>
                                    </td>
                                </tr>
                                <tr id="Pre_Run_Unfasten_A_row1">
                                    <td>
                                        <label for="Pre_Run_RPM_A"><?php echo $text['Pre_Run_RPM']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Pre_Run_RPM_A"  name="Pre_Run_RPM_A" size="10" value="<?php echo $data['noramlstep']['step_prr_rpm'];?>" type="text" pattern="\d*" maxlength="4">
                                        <div class="invalid-feedback"><?php echo $error_message['Pre_Run_RPM']; ?></div>
                                    </td>
                                </tr>
                                <tr id="Pre_Run_Unfasten_A_row2">
                                    <td>
                                        <label for="Pre_Run_Angle_A"><?php echo $text['Pre_Run_Angle']; ?> :</label>
                                    </td>
                                    <td>
                                        <input style="font-size:15px; height:30px" class="form-control" id="Pre_Run_Angle_A"  name="Pre_Run_Angle_A" size="10" value="<?php echo $data['noramlstep']['step_prr_angle'];?>" type="text" pattern="\d*" maxlength="5">
                                        <div class="invalid-feedback"><?php echo $error_message['Pre_Run_Angle']; ?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="w3-center" style="margin: 20px 30px 0px 0;">
                <button style="height: 50px; width: 100px; font-size: 25px" id="button1" class="button button3" onclick="save_step();"><?php echo $text['save']; ?></button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function () {
		init();//初始化顯示torque畫面
        set_radio();//設定radio

        <?php
            if($data['noramlstep']['step_targettype'] == 2){
                echo "FunctionKey('Torque');";
            }
            if($data['noramlstep']['step_targettype'] == 1){
                echo "FunctionKey('Angle');";
            }
        ?>

        //切換tab
        var radios = document.querySelectorAll('input[type="radio"]');

        // 添加事件监听
        radios.forEach(function(radio) {
          radio.addEventListener('change', function() {
            var fieldName = this.name;
            var selectedOption = this.value;
            showRows(fieldName, selectedOption);
          });
        });

	});

    // 显示对应的 div
    function showRows(fieldName, option) {
      // 隐藏所有的行
      var rows = document.querySelectorAll('tr[id^="' + fieldName + '"]');
      rows.forEach(function(row) {
        row.style.display = 'none';
      });
      
      // 根据选中的选项显示相应的行
      if (option === '1') {
        var selectedRows = document.querySelectorAll('tr[id^="' + fieldName + '"]');
        selectedRows.forEach(function(row) {
          row.style.display = 'table-row';
        });
      }

      if(fieldName == 'Threshold_Type' || fieldName == 'Threshold_Type_A'){
        if(option == 1){
            $("input[name='Threshold_Type'][value='1']").prop("checked", true);
            $("input[name='Threshold_Type_A'][value='1']").prop("checked", true);
            document.getElementById('tr_threshold_angle').style.display = 'table-row';
            document.getElementById('tr_threshold_torque').style.display = 'none';
            document.getElementById('tr_threshold_angle_A').style.display = 'table-row';
            document.getElementById('tr_threshold_torque_A').style.display = 'none';
        }else{
            $("input[name='Threshold_Type'][value='0']").prop("checked", true);
            $("input[name='Threshold_Type_A'][value='0']").prop("checked", true);
            document.getElementById('tr_threshold_torque').style.display = 'table-row';
            document.getElementById('tr_threshold_angle').style.display = 'none';
            document.getElementById('tr_threshold_torque_A').style.display = 'table-row';
            document.getElementById('tr_threshold_angle_A').style.display = 'none';
        }
      }

    }


    function set_radio() {
        //set radio
        $("#Joint_OffSet_Option").val(<?php echo $data['noramlstep']['step_offsetdirection'] ?>);
        let step_downshift_enable = <?php echo $data['noramlstep']['step_downshift_enable'] ?>;
        let step_monitoringangle = <?php echo $data['noramlstep']['step_monitoringangle'] ?>;
        let step_prr = <?php echo $data['noramlstep']['step_prr'] ?>;
        let threshold_type = <?php echo $data['noramlstep']['step_threshold_mode'] ?>;

        if( step_downshift_enable == '0'){
            $("input[name='Downshift_Enable'][value='0']").prop("checked", true);
            $("input[name='Downshift_Enable_A'][value='0']").prop("checked", true);
            showRows('Downshift_Enable',0);
            showRows('Downshift_Enable_A',0);
        }else{
            $("input[name='Downshift_Enable'][value='1']").prop("checked", true);
            $("input[name='Downshift_Enable_A'][value='1']").prop("checked", true);
        }

        if(step_monitoringangle == '0'){
            $("input[name='Monitoring_Angle'][value='0']").prop("checked", true);
            $("input[name='Over_Angle_Stop'][value='0']").prop("checked", true);
            showRows('Monitoring_Angle',0);
        }else if(step_monitoringangle == '1'){
            $("input[name='Monitoring_Angle'][value='1']").prop("checked", true);
            $("input[name='Over_Angle_Stop'][value='1']").prop("checked", true);
        }else if(step_monitoringangle == '2'){
            $("input[name='Monitoring_Angle'][value='1']").prop("checked", true);
            $("input[name='Over_Angle_Stop'][value='0']").prop("checked", true);
        }

        if(step_prr == '0'){
            $("input[name='Pre_Run_Unfasten'][value='0']").prop("checked", true);
            $("input[name='Pre_Run_Unfasten_A'][value='0']").prop("checked", true);
            showRows('Pre_Run_Unfasten',0);
            showRows('Pre_Run_Unfasten_A',0);
        }else{
            $("input[name='Pre_Run_Unfasten'][value='1']").prop("checked", true);
            $("input[name='Pre_Run_Unfasten_A'][value='1']").prop("checked", true);
        }

        if(threshold_type == '0'){
            $("input[name='Threshold_Type'][value='0']").prop("checked", true);
            $("input[name='Threshold_Type_A'][value='0']").prop("checked", true);
            showRows('Threshold_Type',0);
            // showRows('Threshold_Type_A',0);
        }else{
            $("input[name='Threshold_Type'][value='1']").prop("checked", true);
            $("input[name='Threshold_Type_A'][value='1']").prop("checked", true);
            showRows('Threshold_Type',1);
        }

    }

    function save_step() {
        let ss = document.getElementById("TorqueDisplay").style.display;
        let ss2 = document.getElementById("AngleDisplay").style.display;
        let target_type = 'torque';

        if(ss == 'block'){
            target_type = 'torque';
        }else{
            target_type = 'angle';
        }

        let monitoringangle = 0;
        if ($('input[name=Monitoring_Angle]:checked').val() == 1){
            if ($('input[name=Over_Angle_Stop]:checked').val() == 1){
                monitoringangle = 1;
            }else{
                monitoringangle = 2;
            }
        }

        let result =  form_normalstep_validate(target_type);

        if(target_type == 'torque'){
            var formData = {
                target_type : target_type,
                job_id : $("#job_id").val(),
                Seq_ID : $("#Seq_ID").val(),
                Target_Torque : $("#Target_Torque").val(),
                Target_Angle : $("#Target_Angle_A").val(),
                Run_Down_Speed : $("#Run_Down_Speed").val(),
                Hi_Torque : $("#Hi_Torque").val(),
                Low_Torque : $("#Low_Torque").val(),
                Threshold_Torque : $("#Threshold_Torque").val(),
                Joint_OffSet_Option : $("#Joint_OffSet_Option").val(),
                Joint_OffSet : $("#Joint_OffSet").val(),
                Downshift_Torque : $("#Downshift_Torque").val(),
                Downshift_Speed : $("#Downshift_Speed").val(),
                Downshift_Enable : $('input[name=Downshift_Enable]:checked').val(),
                Monitoring_Angle : monitoringangle,
                Pre_Run_Unfasten : $('input[name=Pre_Run_Unfasten]:checked').val(),
                High_Angle : $("#High_Angle").val(),
                Low_Angle : $("#Low_Angle").val(),
                Pre_Run_RPM : $("#Pre_Run_RPM").val(),
                Pre_Run_Angle : $("#Pre_Run_Angle").val(),
                Threshold_Type : $('input[name=Threshold_Type]:checked').val(),
                Threshold_Angle : $("#Threshold_Angle").val(),
            };
        }

        if(target_type == 'angle'){
            var formData = {
                target_type : target_type,
                job_id : $("#job_id").val(),
                Seq_ID : $("#Seq_ID").val(),
                Target_Angle : $("#Target_Angle_A").val(),
                Run_Down_Speed : $("#Run_Down_Speed_A").val(),
                Hi_Torque : $("#Hi_Torque_A").val(),
                Low_Torque : $("#Low_Torque_A").val(),
                Threshold_Torque : $("#Threshold_Torque_A").val(),
                Downshift_Torque : $("#Downshift_Torque_A").val(),
                Downshift_Speed : $("#Downshift_Speed_A").val(),
                Downshift_Enable : $('input[name=Downshift_Enable_A]:checked').val(),
                Pre_Run_Unfasten : $('input[name=Pre_Run_Unfasten_A]:checked').val(),
                High_Angle : $("#Hi_Angle_A").val(),
                Low_Angle : $("#Low_Angle_A").val(),
                Pre_Run_RPM : $("#Pre_Run_RPM_A").val(),
                Pre_Run_Angle : $("#Pre_Run_Angle_A").val(),
                Threshold_Type : $('input[name=Threshold_Type_A]:checked').val(),
                Threshold_Angle : $("#Threshold_Angle_A").val(),
            };
        }

        

        // console.log(formData);
        let job_id = $("#job_id").val();
        let seq_id = $("#Seq_ID").val();
        
        if(result){
            $.ajax({
              type: "POST",
              url: "?url=Normalsteps/edit_step",
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
                location.href = '?url=Sequences/index/'+job_id+'/' ;
              }
              $('#new_job_save').prop('disabled', false);
            });
        }

    }


    //validate form
    function form_normalstep_validate(target_type) {   
        //torque parameter   
        let Target_Torque = document.getElementById("Target_Torque");
        let Run_Down_Speed = document.getElementById("Run_Down_Speed");
        let Downshift_Torque = document.getElementById("Downshift_Torque");
        let Downshift_Speed = document.getElementById("Downshift_Speed");
        let High_Angle = document.getElementById("High_Angle");
        let Low_Angle = document.getElementById("Low_Angle");
        let Pre_Run_RPM = document.getElementById("Pre_Run_RPM");
        let Pre_Run_Angle = document.getElementById("Pre_Run_Angle");
        let Hi_Torque = document.getElementById("Hi_Torque");
        let Low_Torque = document.getElementById("Low_Torque");
        let Threshold_Torque = document.getElementById("Threshold_Torque");
        let Joint_OffSet = document.getElementById("Joint_OffSet");
        let Joint_OffSet_Option = document.getElementById("Joint_OffSet_Option");

        let Target_Angle_A = document.getElementById("Target_Angle_A");
        let Run_Down_Speed_A = document.getElementById("Run_Down_Speed_A");
        let Threshold_Torque_A = document.getElementById("Threshold_Torque_A");
        let Downshift_Torque_A = document.getElementById("Downshift_Torque_A");
        let Downshift_Speed_A = document.getElementById("Downshift_Speed_A");
        let Pre_Run_RPM_A = document.getElementById("Pre_Run_RPM_A");
        let Pre_Run_Angle_A = document.getElementById("Pre_Run_Angle_A");
        let Hi_Angle_A = document.getElementById("Hi_Angle_A");
        let Low_Angle_A = document.getElementById("Low_Angle_A");
        let Hi_Torque_A = document.getElementById("Hi_Torque_A");
        let Low_Torque_A = document.getElementById("Low_Torque_A");

        let Tool_Max_Torque = parseFloat(document.getElementById('Tool_Max_Torque').value);
        let Tool_Min_Torque = parseFloat(document.getElementById('Tool_Min_Torque').value);
        let Tool_Max_RPM = parseFloat(document.getElementById('tool_maxrpm').value);
        let Tool_Min_RPM = parseFloat(document.getElementById('tool_minrpm').value);
        let Target_Torque_value = parseFloat(Target_Torque.value);
        let Torque_Unit = document.getElementById("torque_unit").value;
        let delta = document.getElementById('delta').value;

        if(target_type == 'torque'){
            let Threshold_Torque_value = parseFloat(Threshold_Torque.value);
            let Downshift_Speed_value = parseFloat(Downshift_Speed.value);
            let Downshift_Enable_value = $('input[name=Downshift_Enable]:checked').val();
            let Monitoring_Angle_value = $('input[name=Monitoring_Angle]:checked').val();
            let Pre_Run_Unfasten_value = $('input[name=Pre_Run_Unfasten]:checked').val();

            let Threshold_Type_value = $('input[name=Threshold_Type]:checked').val();

            if(Threshold_Type_value == 0){//torque
                document.getElementById("Threshold_Angle").value = 0;
            }else{//angle
                Threshold_Torque.value = 0;
            }

            //關閉就帶入預設值
            if(Downshift_Enable_value == 0){
                Downshift_Torque.value = 0;
                Downshift_Speed.value = Tool_Min_RPM;
                Threshold_Torque_value = 0;
            }
            if(Monitoring_Angle_value == 0){
                High_Angle.value = 30600;
                Low_Angle.value = 0;
            }
            if(Pre_Run_Unfasten_value == 0){
                Pre_Run_RPM.value = 200;
                Pre_Run_Angle.value = 1800;
            }

            let HQ_range = '';
            let LQ_range = '';
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
            document.getElementById('LA_range').textContent = '0 - ' + (High_Angle.value-1);
            document.getElementById('HA_range').textContent = '1 - 30600';

            var inputs = [
                //torque
                { id: 'Target_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: Tool_Min_Torque, max: Tool_Max_Torque },
                { id: 'Run_Down_Speed', pattern: /^\d{0,5}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Hi_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: Number.parseFloat( parseFloat(Target_Torque_value) + parseFloat(delta) ).toFixed(4), max: Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Low_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Number.parseFloat( parseFloat(Target_Torque_value) - parseFloat(delta) ).toFixed(4) },
                { id: 'Threshold_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value },
                { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value },
                { id: 'Downshift_Torque', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value },
                { id: 'Downshift_Speed', pattern: /^\d{0,5}$/, min: Tool_Min_RPM, max: Run_Down_Speed.value },
                { id: 'High_Angle', pattern: /^\d{1,5}$/, min: 1, max: 30600 },
                { id: 'Low_Angle', pattern: /^\d{1,5}$/, min: 0, max: parseFloat(High_Angle.value) },
                { id: 'Pre_Run_RPM', pattern: /^\d{1,5}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Pre_Run_Angle', pattern: /^\d{1,5}$/, min: 1, max: 30600 },
                { id: 'Threshold_Angle', pattern: /^\d{1,5}$/, min: 0, max: 99999 },
            ];

            //join offset要另外判斷
            if(Joint_OffSet_Option.value == '1'){
                inputs[5] = { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Target_Torque_value };
            }else if(Joint_OffSet_Option.value == '0'){
                inputs[5] = { id: 'Joint_OffSet', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: parseFloat(Tool_Max_Torque*1.1 - Target_Torque_value).toFixed(2) };
            }
            
        }

        if(target_type == 'angle'){
            let Threshold_Torque_value = parseFloat(Threshold_Torque_A.value);
            let Downshift_Speed_value = parseFloat(Downshift_Speed_A.value);
            let Downshift_Enable_value = $('input[name=Downshift_Enable_A]:checked').val();
            let Pre_Run_Unfasten_value = $('input[name=Pre_Run_Unfasten_A]:checked').val();
            let Target_Angle_A_value = parseFloat(Target_Angle_A.value);

            let Threshold_Type_value = $('input[name=Threshold_Type_A]:checked').val();

            if(Threshold_Type_value == 0){//torque
                document.getElementById("Threshold_Angle_A").value = 0;
            }else{//angle
                Threshold_Torque_A.value = 0;
            }

            //關閉就帶入預設值
            if(Downshift_Enable_value == 0){
                Downshift_Torque_A.value = 0;
                Downshift_Speed_A.value = Tool_Min_RPM;
                Threshold_Torque_value = 0;
            }
            if(Pre_Run_Unfasten_value == 0){
                Pre_Run_RPM_A.value = 200;
                Pre_Run_Angle_A.value = 1800;
            }

            let HQ_range_A = '';
            let LQ_range_A = '';
            if( Torque_Unit == 0 ){
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta.value) ).toFixed(4);
            }else if( Torque_Unit == 1 ){
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(3);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta.value) ).toFixed(3);
            }else{
                HQ_range_A = Tool_Min_Torque +' - '+Number.parseFloat(Tool_Max_Torque*1.1).toFixed(2);
                LQ_range_A = '0.0 - '+Number.parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta.value) ).toFixed(2);
            }

            document.getElementById('HQ_range_A').textContent = HQ_range_A;
            document.getElementById('LQ_range_A').textContent = LQ_range_A;
            document.getElementById('HA_range_A').textContent = Target_Angle_A_value + ' - 30600';
            document.getElementById('LA_range_A').textContent = '0 - ' + (Target_Angle_A_value);
            //theshold torque 要小於 hi torque
            // document.getElementById('THS_range_A').textContent = ' 0 -' + Hi_Torque_A.value;
            //THS_range_A


            var inputs = [
                //angle
                { id: 'Target_Angle_A', pattern: /^\d{1,5}$/, min: 1, max: 30600 },
                { id: 'Run_Down_Speed_A', pattern: /^\d{0,4}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Threshold_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: parseFloat(Hi_Torque_A.value) },
                { id: 'Hi_Angle_A', pattern: /^\d{1,5}$/, min: Target_Angle_A_value, max: 30600 },
                { id: 'Low_Angle_A', pattern: /^\d{1,6}$/, min: 0, max: Target_Angle_A_value },
                { id: 'Hi_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Number.parseFloat(Tool_Max_Torque*1.1).toFixed(4) },
                { id: 'Low_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: parseFloat( parseFloat(Hi_Torque_A.value) - parseFloat(delta.value) ).toFixed(4) },
                { id: 'Downshift_Torque_A', pattern: /^\d{0,6}(\.\d{0,4})?$/, min: 0, max: Hi_Torque_A.value },
                { id: 'Downshift_Speed_A', pattern: /^\d{0,4}$/, min: Tool_Min_RPM, max: Run_Down_Speed_A.value },
                { id: 'Pre_Run_RPM_A', pattern: /^\d{2,4}$/, min: Tool_Min_RPM, max: Tool_Max_RPM },
                { id: 'Pre_Run_Angle_A', pattern: /^\d{1,5}$/, min: 1, max: 30600 },
                { id: 'Threshold_Angle_A', pattern: /^\d{1,5}$/, min: 0, max: Target_Angle_A_value },
            ];

        }

        var isFormValid = true; // 表单验证状态，默认为通过
        let not_exceed = ['Threshold_Torque', 'Downshift_Torque', 'Downshift_Speed']; //要小於最大值

        inputs.forEach(function(input) {
            var element = document.getElementById(input.id);
            var value = element.value.trim();

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
            } else if ( !not_exceed.includes(input.id) && parseFloat(input.max) !== null && parseFloat(value) > parseFloat(input.max) ) {                
                element.classList.add("is-invalid");
                isFormValid = false;
            } else if ( not_exceed.includes(input.id) && parseFloat(input.max) !== null && parseFloat(value) >= parseFloat(input.max)) {
                element.classList.add("is-invalid");
                isFormValid = false;
            } else {
                element.classList.remove("is-invalid");
            }
        });

        // console.log(isFormValid);

        return isFormValid;
    }

    function validateInput(inputId, regexPattern, min, max) {
      var input = document.getElementById(inputId);
      var value = input.value.trim();

      if(inputId == 'Downshift_Torque'){
        // console.log(value)
        // console.log(min)
        // console.log(max)
      }

      if (!regexPattern.test(value) || value < min || value > max || value ==="" ) {
        input.classList.add("is-invalid");
        return false;
      } else {
        input.classList.remove("is-invalid");
        return true;
      }
    }


</script>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs()
    document.getElementById("return").disabled = false;
  });
</script>
<?php } ?>