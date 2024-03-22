<?php require APPROOT . 'views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./css/input_m.css">
<script src="./js/input.js"></script>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                    <h3><?php echo $text['input']; ?></h3>
                </td>
                <td>
                    <button id="home" class="w3-btn w3-round-large" style="height:50px;padding: 0" onclick="window.location.href='./?url=Dashboards'"><img src="./img/btn_home.png"></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content">
        <div class="center-content">
            <div id="DivMode">
                <div id="Table_JobID">
                    <table class="w3-table w3-striped">
                        <tr>
                            <td>
                                <label style="color: #000; margin-right: 5px" for="Job_Name"><?php echo $text['job']; ?>:</label>
                                <div id="job_name_div" style=" display: contents; " onclick="document.getElementById('JobSelect').style.display='block'">
                                    <input style="height:35px; font-size:18px;display:none;" type="text" id="input_alljob" value="<?php echo $data['device_data']['device_input_alljob']; ?>" disabled>
                                    <input style="height:35px; font-size:18px;display:none;" type="text" id="job_id" value="" disabled>
                                    <input style="height:35px; font-size:18px" type="text" id="Job_Name" name="Job_Name" size="15" maxlength="10" value="" disabled>

                                </div>
                                <button class="w3-grey" style="width: auto;height: 35px;font-size: 15px; border-radius: 5px" id="Button_Select" type="button" onclick="document.getElementById('JobSelect').style.display='block'"><?php echo $text['select']; ?></button>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Job Select Modal -->
                <div id="JobSelect" class="modal">
                    <form class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 400px; top: 10%" action="">
                        <div class="container2 w3-light-grey">
                            <header class="w3-container w3-dark-grey" style="height: 48px">
                                <span onclick="document.getElementById('JobSelect').style.display='none'" class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                                <h3 style="margin: 5px"><?php echo $text['job_select']; ?></h3>
                            </header>
                            <table id="Job_Select" style="margin: 5px 10px 10px;width:94%">
                                <tr>
                                    <td>
                                        <select style="margin: center;text-align: center;" id="JobNameSelect" name="JobNameSelect" size="200">
                                            <option value="-1" disabled selected><?php echo $text['select_job']; ?></option>
                                            <?php foreach ($data['job_list'] as $key => $value) {
                                                if($value['job_id'] < 100){
                                                    echo "<option value='".$value['job_id']."' >Nor-".$value['job_id']." ".$value['job_name']."</option>";
                                                }else{
                                                    echo "<option value='".$value['job_id']."' >Adv-".$value['job_id']." ".$value['job_name']."</option>";
                                                }
                                            }?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-center w3-dark-grey" style="height: 48px">
                            <button id="select_confirm" type="button" class="btn btn-primary" onclick="job_input();"><?php echo $text['confirm']; ?></button>
                            <button id="select_close" type="button" class="btn btn-secondary" onclick="document.getElementById('JobSelect').style.display='none'" ><?php echo $text['close']; ?></button>
                        </div>
                    </form>
                </div>

                <div id="TableInput">
                    <div id="TableInputSetting" align="center">
                        <div class="scrollbar" id="style-input">
                            <div class="force-overflow">
                                <table id="input_table" class="w3-table-all w3-hoverable " style="margin-top: 0px !important;width: 100%;">
                                    <thead id="header-table">
                                        <tr style="height:30px; font-size: 15px;" class="w3-dark-grey">
                                            <th class="w3-center" width="60%"><?php echo $text['event']; ?></th>
                                            <th class="w3-center" style="display: none;">2</th>
                                            <th class="w3-center" style="display: none;">3</th>
                                            <th class="w3-center" style="display: none;">4</th>
                                            <th class="w3-center" style="display: none;">5</th>
                                            <th class="w3-center" style="display: none;">6</th>
                                            <th class="w3-center" style="display: none;">7</th>
                                            <th class="w3-center" style="display: none;">8</th>
                                            <th class="w3-center" style="display: none;">9</th>
                                            <th class="w3-center" style="display: none;">10</th>
                                            <th class="w3-center" width="20%">Pin</th>
                                            <th class="w3-center" width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="footer">
                        <div class="buttonbox">
                            <input id="S1" name="New_Submit" type="button" value="<?php echo $text['New']; ?>" tabindex="1" onclick="crud_job_event('new')">
                            <input id="S2" name="Edit_Submit" type="button" value="<?php echo $text['Edit']; ?>" tabindex="1" onclick="crud_job_event('edit')">
                            <input id="S3" name="Copy_Submit" type="button" value="<?php echo $text['Copy']; ?>" tabindex="1" onclick="crud_job_event('copy')">
                            <input id="S4" name="Delete_Submit" type="button" value="<?php echo $text['Delete']; ?>" tabindex="1" onclick="crud_job_event('del')">
                            <input id="S5" name="Table_Submit" type="button" value="<?php echo $text['Table']; ?>" tabindex="1" onclick="TableSubmit('Table')">
                            <input id="S6" name="Align_Submit" type="button" value="<?php echo $text['Align']; ?>" tabindex="1" onclick="crud_job_event('align')">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div id="TableDataInput">
                    <div id="TableInputData" align="center" class="w3-border-bottom">
                        <div class="scrollbar-detail tabledetail-container" id="style-inputdetail">
                            <div class="force-overflow-detail">
                                <table id="detail_table" class="w3-table-all w3-hoverable">
                                    <thead id="head-thead">
                                        <tr style="height:48px; font-size: 14px;" class="w3-dark-grey">
                                            <th  width="20%">P</th>
                                            <th class="w3-center" width="7.25%">Mode</th>
                                            <th class="w3-center" width="7.25%">Evt</th>
                                            <th class="w3-center" width="7.25%">2</th>
                                            <th class="w3-center" width="7.25%">3</th>
                                            <th class="w3-center" width="7.25%">4</th>
                                            <th class="w3-center" width="7.25%">5</th>
                                            <th class="w3-center" width="7.25%">6</th>
                                            <th class="w3-center" width="7.25%">7</th>
                                            <th class="w3-center" width="7.25%">8</th>
                                            <th class="w3-center" width="7.25%">9</th>
                                            <th class="w3-center" width="7.25%">10</th>
                                            <th class="w3-center" width="7.25%">Conf</th>
                                        </tr>
                                    </thead>
                                    <tbody style="height:45px; font-size: 14px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="Event_List" align="center">
                        <div style="text-align: left;"><b>Event List</b></div>
                        <table class="w3-table-all w3-round" style="font-size: 14px">
                            <tr>
                                <td>1-170 SW Job ID</td>
                                <td>203 <?php echo $text['ENABLE']; ?></td>
                                <td>207 <?php echo $text['REBOOT']; ?></td>
                                <!-- <td>211 <?php echo $text['GATE_TWICE']; ?></td> -->
                            </tr>
                            <tr>
                                <td>200 <?php echo $text['START_IN']; ?></td>
                                <td>204 <?php echo $text['CONFIRM']; ?></td>
                                <td>208 <?php echo $text['UDEFINE1']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>201 <?php echo $text['REVERSE']; ?></td>
                                <td>205 <?php echo $text['CLEAR']; ?></td>
                                <td>209 <?php echo $text['UDEFINE2']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>202 <?php echo $text['DISABLE']; ?></td>
                                <td>206 <?php echo $text['SEQ_CLEAR']; ?></td>
                                <td>210 <?php echo $text['GATE_ONCE']; ?></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="left">
                        <button id="button_Close" class="button button3" onclick="TableSubmit('List')"><?php echo $text['close']; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

                <!-- Input New Modal -->
                <div id="InputNew" class="modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 550px;">
                        <header class="w3-container w3-dark-grey" style="height: 48px">
                            <span onclick="document.getElementById('InputNew').style.display='none'" class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                            <h3 id="modal_title" style="margin: 5px">New Input</h3>
                        </header>
                        <div style="padding: 16px;">
                            <label style=" font-size: 15px" for="Event">
                                <?php echo $text['event']; ?> :</label>&nbsp;
                            <select id="event_select" style="margin: 0px 0px 0px;padding-left: 5px;">
                                <option value="-1" disabled selected>
                                    <?php echo $text['Choose_option']; ?>
                                </option>
                                <option value="200"><?php echo $text['START_IN']; ?></option>
                                <option value="201"><?php echo $text['REVERSE_IN']; ?></option>
                                <option value="202"><?php echo $text['DISABLE']; ?></option>
                                <option value="203"><?php echo $text['ENABLE']; ?></option>
                                <option value="204"><?php echo $text['CONFIRM']; ?></option>
                                <option value="205"><?php echo $text['CLEAR']; ?></option>
                                <option value="206"><?php echo $text['SEQ_CLEAR']; ?></option>
                                <option value="207"><?php echo $text['REBOOT']; ?></option>
                                <option value="208"><?php echo $text['UDEFINE1']; ?></option>
                                <option value="209"><?php echo $text['UDEFINE2']; ?></option>
                                <option value="210"><?php echo $text['GATE_ONCE']; ?></option>
                                <!-- <option value="211"><?php echo $text['GATE_TWICE']; ?></option> -->
                                <?php
                                    foreach($data['job_list'] as $key => $value) {
                                        if ($value['job_id'] < 100) {
                                            echo "<option value='".$value['job_id'].
                                            "' >SW Nor-".$value['job_id'].
                                            " ".$value['job_name'].
                                            "</option>";
                                        } else {
                                            echo "<option value='".$value['job_id'].
                                            "' >SW Adv-".$value['job_id'].
                                            " ".$value['job_name'].
                                            "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <table id="InputNew_Modal" class="w3-table w3-large">
                            <tr>
                                <td>
                                    <label for="Input2">2 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_2_On" name="Input_New" value="2_on" type="radio">
                                    <label for="Input_2_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_2_Off" name="Input_New" value="2_off" type="radio">
                                    <label for="Input_2_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                                <td>
                                    <label for="Input7">7 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_7_On" name="Input_New" value="7_on" type="radio">
                                    <label for="Input_7_On"><img src="../public/img/high.png" width="30" height="30" alt=""></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_7_Off" name="Input_New" value="7_off" type="radio">
                                    <label for="Input_7_Off"><img src="../public/img/low.png" width="30" height="30" alt=""></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Input3">3 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_3_On" name="Input_New" value="3_on" type="radio">
                                    <label for="Input_3_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_3_Off" name="Input_New" value="3_off" type="radio">
                                    <label for="Input_3_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                                <td>
                                    <label for="Input8">8 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_8_On" name="Input_New" value="8_on" type="radio">
                                    <label for="Input_8_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_8_Off" name="Input_New" value="8_off" type="radio">
                                    <label for="Input_8_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Input4">4 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_4_On" name="Input_New" value="4_on" type="radio">
                                    <label for="Input_4_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_4_Off" name="Input_New" value="4_off" type="radio">
                                    <label for="Input_4_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                                <td>
                                    <label for="Input9">9 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_9_On" name="Input_New" value="9_on" type="radio">
                                    <label for="Input_9_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_9_Off" name="Input_New" value="9_off" type="radio">
                                    <label for="Input_9_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Input5">5 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_5_On" name="Input_New" value="5_on" type="radio">
                                    <label for="Input_5_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_5_Off" name="Input_New" value="5_off" type="radio">
                                    <label for="Input_5_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                                <td>
                                    <label for="Input10">10 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_10_On" name="Input_New" value="10_on" type="radio">
                                    <label for="Input_10_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_10_Off" name="Input_New" value="10_off" type="radio">
                                    <label for="Input_10_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Input6">6 :</label>
                                    <input style="zoom:1.2; margin:2px; vertical-align: middle" id="Input_6_On" name="Input_New" value="6_on" type="radio">
                                    <label for="Input_6_On"><img src="../public/img/high.png" width="30" height="30"></label>
                                    <input style="zoom:1.2; vertical-align: middle" id="Input_6_Off" name="Input_New" value="6_off" type="radio">
                                    <label for="Input_6_Off"><img src="../public/img/low.png" width="30" height="30"></label>
                                </td>
                                <td></td>
                            </tr>
                            <tr id="gate_once_check" style="display: none;">
                            <td colspan="2">
                                <label for="Input6"><?php echo $text['gate_confirm']; ?> :</label>&nbsp;&nbsp;
                                <input style="zoom:1.2; margin:2px; vertical-align: middle" id="" name="goc" value="0" type="radio" >
                                <label for=""><?php echo $text['NO']; ?></label>&nbsp;&nbsp;&nbsp;
                                <input style="zoom:1.2; vertical-align: middle" id="" name="goc" value="1" type="radio" checked>
                                <label for=""><?php echo $text['YES']; ?></label>
                            </td>
                        </tr>
                        </table>
                        <div class="modal-footer justify-content-center w3-dark-grey" style="height: 48px">
                            <button type="button" class="btn btn-primary" onclick="new_job_event_save()"><?php echo $text['confirm']; ?></button>
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('InputNew').style.display='none'" ><?php echo $text['close']; ?></button>

                        </div>
                    </div>
                </div>
                <!-- Copy Modal -->
                <div id="CopyInput" class="modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 500px; top: 15%">
                        <div class="container2 w3-light-grey">
                            <header class="w3-container w3-dark-grey" style="height:48px">
                                <span onclick="document.getElementById('CopyInput').style.display='none'" class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                                <h3 style="margin: 5px"><?php echo $text['copy_input']; ?></h3>
                            </header>
                            <div class="modal-body">
                                <form id="Copy_form">
                                    <div for="from_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_from']; ?></div>
                                    <div style="padding-left: 10px;">
                                        <div class="row">
                                            <div for="from_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['job_id']; ?> :</div>
                                            <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                                <input type="number" class="form-control" id="from_job_id" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div for="from_job_name" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['job_name']; ?> :</div>
                                            <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                                <input type="text" class="form-control" id="from_job_name" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div for="to_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_to']; ?></div>
                                    <div class="row" style="padding-left: 10px;">
                                        <div for="to_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['job']; ?> :</div>
                                        <div class="col"  style="font-size: 18px; margin: 5px 0px 5px">
                                            <select id="to_job_id" name="to_job_id">
                                                <option value="-1" disabled selected><?php echo $text['Choose_option']; ?></option>
                                                <?php foreach ($data['job_list'] as $key => $value) {
                                                    if($value['job_id'] < 100){
                                                        echo "<option value='".$value['job_id']."' >Nor-".$value['job_id']." ".$value['job_name']."</option>";
                                                    }else{
                                                        echo "<option value='".$value['job_id']."' >Adv-".$value['job_id']." ".$value['job_name']."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer justify-content-center w3-dark-grey" style="height: 48px">
                                <button type="button" class="btn btn-primary" id="copy_input_save" onclick="copy_input_save();" ><?php echo $text['confirm']; ?></button>
                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('CopyInput').style.display='none'" ><?php echo $text['close']; ?></button>
                            </div>
                        </div>
                    </div>
                </div>

    <script>
    $(document).ready(function() {
        init();
        //初始化
        all_job = document.getElementById('input_alljob').value;
        if(all_job != 0){
            document.getElementById('JobNameSelect').value = all_job;
            document.getElementById('Job_Name').style.backgroundColor = 'yellow';
            document.getElementById('job_name_div').onclick = '';
            document.getElementById('Button_Select').onclick = '';
            job_input();
        }



        $('#input_table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                // $(this).removeClass('selected');
            } else {
                // table.$('tr.selected').removeClass('selected');
                $('#input_table tbody tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        document.getElementById('JobNameSelect').ondblclick = function(){
            job_input();
        };

        var select = document.querySelector("#event_select");
        select.addEventListener('change', showDiv);

        function showDiv(e){
          // console.log(e.target.value);
          if( this.value == 210 ){
            document.getElementById('gate_once_check').style.display = 'contents';
            $('input[name="goc"]')[1].checked = true;
          }else{
            document.getElementById('gate_once_check').style.display = 'none';
            $('input[name="goc"]')[0].checked = true;
          }
        }

    });

    // Get the modal
    var modal_JobSelect = document.getElementById('JobSelect');
    var modal_InputNew = document.getElementById('InputNew');
    var modal_CopyInput = document.getElementById('CopyInput');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal_JobSelect || event.target == modal_InputNew || event.target == modal_CopyInput) {
            //close modal
            modal_JobSelect.style.display = "none";
            modal_InputNew.style.display = "none";
            modal_CopyInput.style.display = "none";
            //reset radio and select
            $('input[name="Input_New"]').prop('checked', false);
            document.getElementById('event_select').value = -1;
            document.getElementById('event_select').disabled = false;
        }
    }

    function crud_job_event(argument) {

        let event_id;
        let job_id;
        let rowIndex;
        try { 
          // event_id = document.querySelector("#input_table tr.selected").childNodes[0].textContent;//取得第一欄的值event_id
          rowIndex = document.querySelector("#input_table tr.selected").rowIndex;
          event_id = $('#input_table').DataTable().row(rowIndex-1).data().input_event
        } catch (error) {
          event_id = null; /* 任意默认值都可以被使用 */
        };

        job_id = document.getElementById('job_id').value;

        if(argument == 'new' && job_id != ''){
            initial();
            $('#event_select').prop('selectedIndex',0);
            document.getElementById('event_select').disabled = false;
            document.getElementById('modal_title').innerHTML = '<?php echo $text['new_event']; ?>';
            document.getElementById('InputNew').style.display='block';
        }
        if(argument == 'del' && event_id != null && job_id != ''){
            delete_input(job_id,event_id);
        }
        if(argument == 'edit' && event_id != null && job_id != ''){
            document.getElementById('modal_title').innerHTML = '<?php echo $text['edit_event']; ?>';
            initial();
            if (event_id == 210) { document.getElementById('gate_once_check').style.display = 'contents'; }
            edit_input(job_id,event_id);
        }
        if(argument == 'copy' && job_id != ''){
            const options = document.getElementById("to_job_id").options;
            $('#to_job_id').prop('selectedIndex',0);
            for (var j = 0; j < options.length; j++) {
                options[j].disabled = false;
                if(options[j].value == job_id){
                    options[j].disabled = true;
                }
            }
            copy_input(job_id);
        }
        if(argument == 'align' && job_id != ''){
            AlignSubmit(job_id);
        }
    }

    function event_check(table_id) {//disable select and radio
      var table = document.getElementById(table_id);
      var rows = table.getElementsByTagName("tr");
      var selectMenu = document.getElementById("event_select");
      var options = selectMenu.options;

      //初始化表格
      var inputs = document.querySelectorAll('[name=Input_New]');
        inputs.forEach(function(input) {
            input.disabled = false;
        });
        for (var j = 0; j < options.length; j++) {
            options[j].disabled = false;
        }
      //end 初始化表格

      //依據table中的資料disable欄位
      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cell = row.getElementsByTagName("td")[0];
        var optionValue = cell.innerHTML;
        
        for (var j = 0; j < options.length; j++) {
          if (options[j].value === optionValue) {
            options[j].disabled = true;
            break;
          }
        }

        for (var j = 1; j < row.getElementsByTagName("td").length; j++) {
          if (row.getElementsByTagName("td")[j].innerHTML != '') {
            let target = j + 1;
            document.getElementById("Input_"+target+"_On").disabled = true;
            document.getElementById("Input_"+target+"_Off").disabled = true;
            break;
          }
        }
      }
      //end 依據table中的資料disable欄位

      //調整顯示文字
      let formData = {
          '200': '<?php echo $text['START_IN']; ?>',
          '201': '<?php echo $text['REVERSE_IN']; ?>',
          '202': '<?php echo $text['DISABLE']; ?>',
          '203': '<?php echo $text['ENABLE']; ?>',
          '204': '<?php echo $text['CONFIRM']; ?>',
          '205': '<?php echo $text['CLEAR']; ?>',
          '206': '<?php echo $text['SEQ_CLEAR']; ?>',
          '207': '<?php echo $text['REBOOT']; ?>',
          '208': '<?php echo $text['UDEFINE1']; ?>',
          '209': '<?php echo $text['UDEFINE2']; ?>',
          '210': '<?php echo $text['GATE_ONCE']; ?>',
          '211': '<?php echo $text['GATE_TWICE']; ?>',
        };
      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cell = row.getElementsByTagName("td")[0];
        var optionValue = cell.innerHTML;
        if( parseInt(cell.innerHTML) < parseInt(200)){
            if(parseInt(cell.innerHTML) < 100 ){
                cell.innerHTML = 'SW Nor-'+cell.innerHTML;
            }else{
                cell.innerHTML = 'SW Adv-'+cell.innerHTML;
            }

        }else{
            cell.innerHTML = formData[cell.innerHTML];
        }
      }
      //end 調整顯示文字

      //reset radio and select
      $('input[name="Input_New"]').prop('checked', false);
      $('#event_select').prop('selectedIndex',0);
      document.getElementById("event_select").options[0].disabled = true;

    }

    function initial() {
      let rowdata = $('#input_table').DataTable().rows().data().toArray();
      var table = document.getElementById("input_table");
      var rows = table.getElementsByTagName("tr");
      var selectMenu = document.getElementById("event_select");
      var options = selectMenu.options;
      let job_selected = document.getElementById("JobNameSelect").value;
      let formData = {
          '200': '<?php echo $text['START_IN']; ?>',
          '201': '<?php echo $text['REVERSE_IN']; ?>',
          '202': '<?php echo $text['DISABLE']; ?>',
          '203': '<?php echo $text['ENABLE']; ?>',
          '204': '<?php echo $text['CONFIRM']; ?>',
          '205': '<?php echo $text['CLEAR']; ?>',
          '206': '<?php echo $text['SEQ_CLEAR']; ?>',
          '207': '<?php echo $text['REBOOT']; ?>',
          '208': '<?php echo $text['UDEFINE1']; ?>',
          '209': '<?php echo $text['UDEFINE2']; ?>',
          '210': '<?php echo $text['GATE_ONCE']; ?>',
          '211': '<?php echo $text['GATE_TWICE']; ?>',
        };
        //初始化表格
      var inputs = document.querySelectorAll('[name=Input_New]');
        inputs.forEach(function(input) {
            input.disabled = false;
        });
        for (var j = 0; j < options.length; j++) {
            options[j].disabled = false;
        }
      //end 初始化表格

      //disable gate twice
      // selectMenu.options[9].disabled = true

      document.getElementById('gate_once_check').style.display = 'none'; //hide

      //依據table中的資料disable欄位
      //disable radio
      rowdata.forEach(function(value){
        document.getElementById("Input_"+value['input_pin']+"_On").disabled = true;
        document.getElementById("Input_"+value['input_pin']+"_Off").disabled = true;
        if(value['input_event'] == 202 || value['input_event'] == 203){
            selectMenu.querySelector("option[value='202']").disabled = true;
            selectMenu.querySelector("option[value='203']").disabled = true;
        }
        selectMenu.querySelector("option[value='"+value['input_event']+"']").disabled = true;
      });

      //disable sw job self
      for (var j = 0; j < options.length; j++) {
        if (options[j].value === job_selected) {
          options[j].disabled = true;
          break;
        }
      }
      
    }

    function job_input() {//匯入job的input
        let job_select = document.getElementById("JobNameSelect");
        let value = job_select.value;
        let text = job_select.options[job_select.selectedIndex].text;
        let table = $('#input_table').DataTable({
            // paging: false,
            searching: false,
            bInfo : false,
            "ordering": false,
            // "bPaginate": false,
            "dom": "frti",
            "pageLength": 15,
            destroy:true,
            ajax: {
              url:'?url=Inputs/get_input_by_job_id_m',
              data : {'job_id':value},
              type: 'POST',
              dataSrc: ''
            },
            columns: [
              { data: 'input_event' },
              { data: 'input_pin2',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin3',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin4',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin5',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin6',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin7',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin8',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin9',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin10',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin' },
              { data: 'wave',
                render: function (data, type, row, meta) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              }
            ],

            columnDefs: [
                {
                    targets: '_all',
                    className: 'dt-center'
                    // {"className": "dt-center", "targets": "_all"}
                },
                {
                    targets: [1,2,3,4,5,6,7,8,9],
                    visible: false,
                    searchable: true
                    // {"className": "dt-center", "targets": "_all"}
                }
              ],

            "initComplete": function( settings, json ) {
                event_check('input_table');//表格顯示調整
              }
            });
        let detail_table = $('#detail_table').DataTable({
            // paging: false,
            searching: false,
            bInfo : false,
            "ordering": false,
            // "bPaginate": false,
            "dom": "frti",
            "pageLength": 15,
            destroy:true,
            ajax: {
              url:'?url=Inputs/get_input_by_job_id',
              data : {'job_id':value},
              type: 'POST',
              dataSrc: ''
            },
            columns: [
              { title: 'id',
                data: null,
                render: (data, type, row, meta) => meta.row+1 },
              { data: null, render: (data) => 'EVT' },
              { data: 'input_event' },
              { data: 'input_pin2',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin3',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin4',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin5',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin6',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin7',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin8',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin9',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_pin10',
                render: function (data) {
                    if(data == 0){return '';}
                    if(data == 1){return '<img src="../public/img/high.png" style=" max-width: 50px; ">';}
                    if(data == 2){return '<img src="../public/img/low.png" style=" max-width: 50px; ">';}
                  }
              },
              { data: 'input_gateconfirm',
                render: function (data) {
                    if(data == 0){return 'NO';}
                    if(data == 1){return 'YES';}
                  }
              },
            ],

            columnDefs: [
                {
                    targets: '_all',
                    className: 'dt-center'
                    // {"className": "dt-center", "targets": "_all"}
                }
              ],

            "initComplete": function( settings, json ) {
                // event_check('detail_table');//表格顯示調整
              }
            });
        document.getElementById('JobSelect').style.display='none';
        document.getElementById('Job_Name').value = text;
        document.getElementById('job_id').value = value;
        
    }

    //new job 按下save鍵
    function new_job_event_save(){
        $('#new_job_event_save').prop('disabled', true);
        let event_select = document.getElementById("event_select");
        let event_id = event_select.value;
        let text = event_select.options[event_select.selectedIndex].text;
        let input_pin;
        let option;
        let input_gateconfirm = $('input[name="goc"]:checked').val();

        if(event_id == -1  ){
            return 0;
        }
        try{
            let event_option = $('input[name=Input_New]:checked').val().split('_');
            input_pin = event_option[0];
            option = event_option[1];
        }catch (error){
            return 0;
        }


        var formData = {
          'job_id': $("#job_id").val(),
          'event_id': event_id,
          'input_pin': input_pin,
          'option': option,
          'gateconfirm': input_gateconfirm,
        };

        let valid_result = true;

        if(valid_result){
            $.ajax({
                type: "POST",
                url: "?url=Inputs/check_job_event_conflict",
                data: {'job_id':$("#job_id").val(),'event_id':event_id},
                dataType: "json",
                encode: true,
            }).done(function (dupli) {//成功且有回傳值才會執行
                $.ajax({
                    type: "POST",
                    url: "?url=Inputs/create_input_event",
                    data: formData,
                    dataType: "json",
                    encode: true,
                    beforeSend: function() {
                        $('#overlay').removeClass('hidden');
                    },
                }).done(function(data) { //成功且有回傳值才會執行
                    $('#overlay').addClass('hidden');
                    $('#new_job_event_save').prop('disabled', false);
                    job_input();//reload table
                    document.getElementById('InputNew').style.display='none'
                    document.getElementById('event_select').disabled = false;
                });
            });

        }else{
            $('#new_job_event_save').prop('disabled', false);    
        }

    }

    function edit_input(job_id,event_id) {
        // body...
        rowIndex = document.querySelector("#input_table tr.selected").rowIndex;
        let rowdata = $('#input_table').DataTable().row(rowIndex-1).data();
        let on_off;
        let pin_num;

        for (var i = 2; i <= 10; i++) {
            var pin = "input_pin" + i;
            if (rowdata[pin] !== "0") {
                on_off = rowdata[pin];
                pin_num = i;
            }
        }

        if (on_off==1){on_off='On'}else{on_off='Off'}

        //選好 radio 跟 select
        document.getElementById("Input_"+pin_num+"_"+on_off).checked = true;
        document.getElementById("Input_"+pin_num+"_On").disabled = false;
        document.getElementById("Input_"+pin_num+"_Off").disabled = false;
        document.getElementById('InputNew').style.display='block';

        // $('#event_select').prop('selectedIndex',0);
        document.getElementById('event_select').value = event_id;
        document.getElementById('event_select').disabled = true;

        if( event_id == 210 && rowdata['input_gateconfirm'] == 1 ){
            $('input[name="goc"]')[1].checked = true;
        }else{
            $('input[name="goc"]')[0].checked = true;
        }

        // document.getElementById("event_select").options[0].disabled = true;
        //radio 跟 select 
        //open modal

    }

    function copy_input(job_id,) {
        $.ajax({
          type: "POST",
          url: "?url=Jobs/get_job_by_id",
          data: {'job_id':job_id},
          dataType: "json",
          encode: true,
          async: false,//等待ajax完成
        }).done(function (res) {//成功且有回傳值才會執行
          // console.log(res);

          $("#from_job_id").val(job_id);
          $("#from_job_name").val(res['job_name']);

          document.getElementById('CopyInput').style.display='block'
        });
    }

    //copy input 按下save鍵
    function copy_input_save(){
        $('#copy_input_save').prop('disabled', true);
        let from_job_id = $("#from_job_id").val();
        let to_job_id = $("#to_job_id").val();

        if(to_job_id != null){
            Swal.fire({
                title: '<?php echo $text['input_replace_notice']; ?>',
                showCancelButton: true,
                confirmButtonText: '<?php echo $text['cover_text'];?>',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                // console.log(result)
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "?url=Inputs/copy_input",
                        data: {'from_job_id':from_job_id,'to_job_id':to_job_id},
                        dataType: "json",
                        encode: true,
                        beforeSend: function() {
                            $('#overlay').removeClass('hidden');
                        },
                    }).done(function(data) { //成功且有回傳值才會執行
                        // console.log(data);
                        $('#overlay').addClass('hidden');
                        if (data == true) {
                            $('#copy_input_save').prop('disabled', false);
                            document.getElementById('CopyInput').style.display='none'
                            Swal.fire('<?php echo $text['copy_success']; ?>', '', 'success')
                        }
                    });
                }else{
                    $('#copy_input_save').prop('disabled', false);   
                }
            })
        }else{
            $('#copy_input_save').prop('disabled', false);
        }
    }

    function delete_input(job_id,event_id) {

        //job_id 
        let message = '<?php echo $text['input_delete_notice']; ?>';
        Swal.fire({
            title: message,
            showCancelButton: true,
            confirmButtonText: '<?php echo $text['delete_text'];?>',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "?url=Inputs/delete_input",
                  data: {'job_id':job_id,'event_id':event_id},
                  dataType: "json",
                  encode: true,
                  // async: false,//等待ajax完成
                  beforeSend: function() {
                    $('#overlay').removeClass('hidden');
                  },
                }).done(function (res) {//成功且有回傳值才會執行
                    // location.reload();
                    $('#overlay').addClass('hidden');
                    Swal.fire('<?php echo $text['delete_success']; ?>', '', 'success');
                    job_input();

                });
            }
        })

    }

    function AlignSubmit(job_id) {
        all_job = document.getElementById('input_alljob').value;
        if(all_job != 0){
            job_id = 0;
            document.getElementById('input_alljob').value = 0;
        }
        $.ajax({
            type: "POST",
            url: "?url=Inputs/input_alljob",
            data: { 'job_id': job_id},
            dataType: "json",
            encode: true,
            // async: false, //等待ajax完成
            beforeSend: function() {
                $('#overlay').removeClass('hidden');
            },
        }).done(function(res) { //成功且有回傳值才會執行
            $('#overlay').addClass('hidden');
            if(job_id == 0){
                document.getElementById('Job_Name').style.backgroundColor = '';
                document.getElementById('job_name_div').onclick = function () { document.getElementById('JobSelect').style.display='block';};
                document.getElementById('Button_Select').onclick = function () { document.getElementById('JobSelect').style.display='block';};
                job_input();
            }else{
                location.reload();
            }

        });
    }

    </script>

</div>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs();
    document.getElementById("home").disabled = false; //
    document.getElementById("Button_Select").disabled = false; //
    document.getElementById("JobNameSelect").disabled = false; //
    document.getElementById("select_confirm").disabled = false; //
    document.getElementById("select_close").disabled = false; //
    document.getElementById("button_Close").disabled = false; //
    document.getElementById("S5").disabled = false; //

  });
</script>
<?php } ?>


<?php require APPROOT . 'views/inc/footer.php'; ?>