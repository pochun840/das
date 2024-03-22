<?php require APPROOT . 'views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./css/output_m.css">

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                    <h3><?php echo $text['output']; ?></h3>
                </td>
                <td>
                    <button id="home" class="w3-btn w3-round-large" style="height:50px;padding: 0" onclick="window.location.href='./?url=Dashboards'"> <img src="../public/img/btn_home.png"></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content ">
        <div class="center-content">
            <div id="Table_JobID">
                <table class="w3-table w3-striped">
                    <tr>
                        <td>
                            <label style="color: #000; margin-right: 5px" for="Job_Name"><?php echo $text['job']; ?>:</label>
                            <div id="job_name_div" style=" display: contents; " onclick="document.getElementById('JobSelect').style.display='block'">
                                <input style="height:35px; font-size:18px;display:none;" type="text" id="output_alljob" value="<?php echo $data['device_data']['device_output_alljob']; ?>" disabled>
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
                <form class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 400px; top:10%" action="">
                    <div class="container2 w3-light-grey">
                        <header class="w3-container w3-dark-grey" style="height: 48px">
                            <span onclick="document.getElementById('JobSelect').style.display='none'"
                            class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                            <h3  style="margin: 5px"><?php echo $text['job_select']; ?></h3>
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
                        <button id="select_confirm" type="button" class="btn btn-primary" onclick="job_output();"><?php echo $text['confirm']; ?></button>
                        <button id="select_close" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('JobSelect').style.display='none'"><?php echo $text['close']; ?></button>
                    </div>
                </form>
            </div>

            <div id="OutputSetting">
                <div id="TableOutputSetting">
                    <div class="scrollbar" id="style-output">
                        <div class="force-overflow">
                            <table id="TableOutput" class="w3-table-all w3-hoverable w3-large" style=";width: 100%;">
                                <thead id="header-table">
                                  <tr style="height:48px; font-size: 16px;" class="w3-dark-grey">
                                    <th class="w3-center"><?php echo $text['event']; ?></th>
                                    <th class="w3-center">Pin</th>
                                    <th class="w3-center"></th>
                                    <th class="w3-center"><?php echo $text['time']; ?></th>
                                  </tr>
                                </thead>
                                <tbody style="height:45px; font-size: 16px;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="buttonbox">
            <input id="S1" name="New_Submit" type="button" value="<?php echo $text['New']; ?>" tabindex="1" onclick="crud_job_event('new')">
            <input id="S2" name="Edit_Submit" type="button" value="<?php echo $text['Edit']; ?>" tabindex="1" onclick="crud_job_event('edit')">
            <input id="S3" name="Copy_Submit" type="button" value="<?php echo $text['Copy']; ?>" tabindex="1" onclick="crud_job_event('copy')">
            <input id="S4" name="Delete_Submit" type="button" value="<?php echo $text['Delete']; ?>" tabindex="1" onclick="crud_job_event('del')">
            <input id="S6" name="Align_Submit" type="button" value="<?php echo $text['Align']; ?>" tabindex="1" onclick="crud_job_event('align')">
        </div>
    </div>
    <!-- New Modal -->
    <div id="OutputNew" class="modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 650px; top: 1%">
            <header class="w3-container w3-dark-grey" style="height: 48px">
                <span onclick="document.getElementById('OutputNew').style.display='none'"
                class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                <h3 id="modal_title" style="margin: 5px">New Output</h3>
            </header>
            <table id="OutputNew_Modal"class="w3-table w3-large">
                <tr>
                    <td colspan="2">
                        <form id="Select_Event" action="#">
                            <label style=" font-size: 20px" for="Event"><?php echo $text['event']; ?> :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select id="event_select" style="margin: 0px 0px 10px" onchange="option_ini()">
                                <option value="-1" disabled selected><?php echo $text['Choose_option']; ?></option>
                                <option value="1"><?php echo $text['OK']; ?></option>
                                <option value="2"><?php echo $text['NG']; ?></option>
                                <option value="3"><?php echo $text['NG_HIGH']; ?></option>
                                <option value="4"><?php echo $text['NG_LOW']; ?></option>
                                <option value="5"><?php echo $text['OK_SEQ']; ?></option>
                                <option value="6"><?php echo $text['OK_JOB']; ?></option>
                                <option value="7"><?php echo $text['TOOL_RUNNING']; ?></option>
                                <option value="8"><?php echo $text['TOOL_TRIGGER']; ?></option>
                                <option value="9"><?php echo $text['REVERSE']; ?></option>
                                <option value="10"><?php echo $text['UDEFINE1']; ?></option>
                                <option value="11"><?php echo $text['UDEFINE2']; ?></option>
                                <!-- <option value="12"><?php echo $text['SYS_READY']; ?></option> -->
                            </select>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output_1">1 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_1_signal01" name="Output_Option" value="1_01" type="radio" onclick="toggleOnputTime('Time1', this.checked,'1')">
                        <label for="output_1_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_1_signal02" name="Output_Option" value="1_02" type="radio" onclick="toggleOnputTime('Time1', this.checked,'2')">
                        <label for="output_1_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_1_trigger" name="Output_Option" value="1_03" type="radio" onclick="toggleOnputTime('Time1', this.checked,'3')">
                        <label for="output_1_trigger"><img class="bigger" src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time1" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output2">2 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_2_signal01" name="Output_Option" value="2_01" type="radio" onclick="toggleOnputTime('Time2', this.checked,'1')">
                        <label for="output_2_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_2_signal02" name="Output_Option" value="2_02" type="radio" onclick="toggleOnputTime('Time2', this.checked,'2')">
                        <label for="output_2_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_2_trigger" name="Output_Option" value="2_03" type="radio" onclick="toggleOnputTime('Time2', this.checked,'3')">
                        <label for="output_2_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time2" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output3">3 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_3_signal01" name="Output_Option" value="3_01" type="radio" onclick="toggleOnputTime('Time3', this.checked,'1')">
                        <label for="output_3_signal01"><img src="../public/img/signal01.png" width="30" height="30" alt=""></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_3_signal02" name="Output_Option" value="3_02" type="radio" onclick="toggleOnputTime('Time3', this.checked,'2')">
                        <label for="output_3_signal02"><img src="../public/img/signal02.png" width="30" height="30" alt=""></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_3_trigger" name="Output_Option" value="3_03" type="radio" onclick="toggleOnputTime('Time3', this.checked,'3')">
                        <label for="output_3_trigger"><img src="../public/img/trigger_2.png" width="50" height="23" alt=""></label>&nbsp;
                        <input id="Time3" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output4">4 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_4_signal01" name="Output_Option" value="4_01" type="radio" onclick="toggleOnputTime('Time4', this.checked,'1')">
                        <label for="output_4_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_4_signal02" name="Output_Option" value="4_02" type="radio" onclick="toggleOnputTime('Time4', this.checked,'2')">
                        <label for="output_4_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_4_trigger" name="Output_Option" value="4_03" type="radio" onclick="toggleOnputTime('Time4', this.checked,'3')">
                        <label for="output_4_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time4" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output5">5 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_5_signal01" name="Output_Option" value="5_01" type="radio" onclick="toggleOnputTime('Time5', this.checked,'1')">
                        <label for="output_5_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_5_signal02" name="Output_Option" value="5_02" type="radio" onclick="toggleOnputTime('Time5', this.checked,'2')">
                        <label for="output_5_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_5_trigger" name="Output_Option" value="5_03" type="radio" onclick="toggleOnputTime('Time5', this.checked,'3')">
                        <label for="output_5_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time5" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output6">6 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_6_signal01" name="Output_Option" value="6_01" type="radio" onclick="toggleOnputTime('Time6', this.checked,'1')">
                        <label for="output_6_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_6_signal02" name="Output_Option" value="6_02" type="radio" onclick="toggleOnputTime('Time6', this.checked,'2')">
                        <label for="output_6_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_6_trigger" name="Output_Option" value="6_03" type="radio" onclick="toggleOnputTime('Time6', this.checked,'3')">
                        <label for="output_6_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time6" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output7">7 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_7_signal01" name="Output_Option" value="7_01" type="radio" onclick="toggleOnputTime('Time7', this.checked,'1')">
                        <label for="output_7_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_7_signal02" name="Output_Option" value="7_02" type="radio" onclick="toggleOnputTime('Time7', this.checked,'2')">
                        <label for="output_7_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_7_trigger" name="Output_Option" value="7_03" type="radio" onclick="toggleOnputTime('Time7', this.checked,'3')">
                        <label for="output_7_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time7" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output8">8 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_8_signal01" name="Output_Option" value="8_01" type="radio" onclick="toggleOnputTime('Time8', this.checked,'1')">
                        <label for="output_8_signal01"><img src="../public/img/signal01.png" width="30" height="30" alt=""></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_8_signal02" name="Output_Option" value="8_02" type="radio" onclick="toggleOnputTime('Time8', this.checked,'2')">
                        <label for="output_8_signal02"><img src="../public/img/signal02.png" width="30" height="30" alt=""></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_8_trigger" name="Output_Option" value="8_03" type="radio" onclick="toggleOnputTime('Time8', this.checked,'3')">
                        <label for="output_8_trigger"><img src="../public/img/trigger_2.png" width="50" height="23" alt=""></label>&nbsp;
                        <input id="Time8" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent; " disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Output9">9 :</label>&nbsp;
                        <input style="zoom:1.5; vertical-align: middle" id="output_9_signal01" name="Output_Option" value="9_01" type="radio" onclick="toggleOnputTime('Time9', this.checked,'1')">
                        <label for="output_9_signal01"><img src="../public/img/signal01.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_9_signal02" name="Output_Option" value="9_02" type="radio" onclick="toggleOnputTime('Time9', this.checked,'2')">
                        <label for="output_9_signal02"><img src="../public/img/signal02.png" width="30" height="30"></label>&nbsp;

                        <input style="zoom:1.5; vertical-align: middle" id="output_9_trigger" name="Output_Option" value="9_03" type="radio" onclick="toggleOnputTime('Time9', this.checked,'3')">
                        <label for="output_9_trigger"><img src="../public/img/trigger_2.png" width="50" height="23"></label>&nbsp;
                        <input id="Time9" placeholder='ms' type='text' size="5" maxlength="5" value="" style="text-align: center; background-color: #DDDDDD; border-color: transparent;" disabled>
                    </td>
                </tr>
            </table>
            <div class="modal-footer justify-content-center w3-dark-grey" style="height: 48px">
                <button type="button" class="btn btn-primary" id="new_job_output_save" onclick="new_job_output_save()" >Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('OutputNew').style.display='none'">Close</button>
            </div>
        </div>
    </div>

    <!-- Copy Modal -->
    <div id="CopyOutput" class="modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="width: 500px; top: 15%">
            <div class="container2 w3-light-grey">
                <header class="w3-container w3-dark-grey" style="height:48px">
                    <span onclick="document.getElementById('CopyOutput').style.display='none'"
                    class="w3-button w3-red w3-large w3-display-topright" style="margin: 2px">&times;</span>
                    <h3 style="margin: 5px"><?php echo $text['copy_output']; ?></h3>
                </header>
                <div class="modal-body">
                    <form id="Copy_form">
                        <div for="from_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_from']; ?></div>
                        <div style="padding-left: 10px">
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

                        <div for="from_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['copy_to']; ?> </div>
                        <div class="row" style="padding-left: 10px;">
                            <div for="from_job_id" class="col-5" style="font-size: 18px; margin: 5px 0px 5px">Job :</div>
                            <div class="col" style="font-size: 18px; margin: 5px 0px 5px">
                                <select class="col-sm-4" style="margin: center" id="to_job_id" name="to_job_id">
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
                    <button type="button" class="btn btn-primary" id="copy_output_save" onclick="copy_output_save();"><?php echo $text['confirm']; ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('CopyOutput').style.display='none'"><?php echo $text['close']; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    //初始化
    all_job = document.getElementById('output_alljob').value;
    if (all_job != 0) {
        document.getElementById('JobNameSelect').value = all_job;
        document.getElementById('Job_Name').style.backgroundColor = 'yellow';
        document.getElementById('job_name_div').onclick = '';
        document.getElementById('Button_Select').onclick = '';
        job_output();
    }
    // Get the modal
    var JobSelect_modal = document.getElementById('JobSelect');
    var OutputNew_modal = document.getElementById('OutputNew');
    var CopyOutput_modal = document.getElementById('CopyOutput');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == JobSelect_modal || event.target == OutputNew_modal || event.target == CopyOutput_modal) {
            JobSelect_modal.style.display = "none";
            OutputNew_modal.style.display = "none";
            CopyOutput_modal.style.display = "none";
        }
    }

    $('#TableOutput tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            // $(this).removeClass('selected');
        } else {
            // table.$('tr.selected').removeClass('selected');
            $('#TableOutput tbody tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    document.getElementById('JobNameSelect').ondblclick = function(){
        job_output();
    };

    var timeInputs = document.querySelectorAll('input[id^="Time"]');

      // 監聽每個input元素的輸入事件
      timeInputs.forEach(function(input) {
        input.addEventListener('input', function() {
          // 檢查輸入的值是否符合限制條件
          var value = parseInt(this.value);
          if (isNaN(value) || value < 1 || value > 10000) {
            this.value = ''; // 清空輸入值
          }
        });
      });
});

    function toggleOnputTime(inputId, checked,option) { //點選才可以填時間
        var inputTime = document.getElementById(inputId);
        if(option == '2'){ 
            inputTime.disabled = !checked; 
        }else{ 
            inputTime.value = '';
            inputTime.disabled = checked; 
        }
        // console.log(checked);

        var allInputTimes = document.querySelectorAll('input[type="text"][id^="Time"]');
        for (var i = 0; i < allInputTimes.length; i++) {
          var currentInputTime = allInputTimes[i];
          if (currentInputTime.id !== inputId) {
            currentInputTime.disabled = true;
            currentInputTime.value = '';
          }
        }
      }

    function crud_job_event(argument) {

        let event_id;
        let job_id;
        let rowIndex;
        try { 
          // event_id = document.querySelector("#input_table tr.selected").childNodes[0].textContent;//取得第一欄的值event_id
          rowIndex = document.querySelector("#TableOutput tr.selected").rowIndex;
          event_id = $('#TableOutput').DataTable().row(rowIndex-1).data().output_event
        } catch (error) {
          event_id = null; /* 任意默认值都可以被使用 */
        };

        job_id = document.getElementById('job_id').value;

        if(argument == 'new' && job_id != ''){
            initial();
            $('#event_select').prop('selectedIndex',0);
            document.getElementById('event_select').disabled = false;
            document.getElementById('modal_title').innerHTML = '<?php echo $text['new_event']; ?>';
            document.getElementById('OutputNew').style.display='block';
        }
        if(argument == 'del' && event_id != null && job_id != ''){
            delete_output(job_id,event_id);
        }
        if(argument == 'edit' && event_id != null && job_id != ''){
            document.getElementById('modal_title').innerHTML = '<?php echo $text['edit_event']; ?>';
            initial();
            edit_output(job_id,event_id);
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

            copy_output(job_id);
        }
        if(argument == 'align' && job_id != ''){
            AlignSubmit(job_id);
        }
    }

    function job_output() { //匯入job的input
        let job_select = document.getElementById("JobNameSelect");
        let value = job_select.value;
        let text = job_select.options[job_select.selectedIndex].text;
        let table = $('#TableOutput').DataTable({
            // paging: false,
            searching: false,
            bInfo: false,
            "ordering": false,
            // "bPaginate": false,
            "dom": "frti",
            "pageLength": 15,
            destroy: true,
            ajax: {
                url: '?url=Outputs/get_output_by_job_id',
                data: { 'job_id': value },
                type: 'POST',
                dataSrc: ''
            },
            columns: [
                { data: 'output_event' },
                {
                    data: 'output_pin'
                },
                {
                    data: 'output_pin',//pin1
                    render: function ( data, type, row, meta )  {
                        if(row.wave == 1){ return '<img src="../public/img/signal01.png" style=" max-width: 50px; ">'; }
                        if(row.wave == 2){ return '<img src="../public/img/signal02.png" style=" max-width: 50px; ">'; }
                        if(row.wave == 3){ return '<img src="../public/img/trigger_2.png" style=" max-width: 50px; ">'; }
                    }
                },
                {
                    data: 'wave_on',
                    render: function ( data, type, row, meta )  {
                        if(row.wave_on == 0){ return ''; }
                        else{ return data;}
                    }
                },
                    
            ],

            columnDefs: [{
                targets: '_all',
                className: 'dt-center'
            }],

            "initComplete": function(settings, json) {
                event_check('TableOutput'); //表格顯示調整
            }
        });

        document.getElementById('JobSelect').style.display = 'none';
        document.getElementById('Job_Name').value = text;
        document.getElementById('job_id').value = value;
     }

    function event_check(table_id) {//disable select and radio
      var table = document.getElementById(table_id);
      var rows = table.getElementsByTagName("tr");
      var selectMenu = document.getElementById("event_select");
      var options = selectMenu.options;

      //調整顯示文字
      let formData = {
          '1': '<?php echo $text['OK']; ?>',
          '2': '<?php echo $text['NG']; ?>',
          '3': '<?php echo $text['NG_HIGH']; ?>',
          '4': '<?php echo $text['NG_LOW']; ?>',
          '5': '<?php echo $text['OK_SEQ']; ?>',
          '6': '<?php echo $text['OK_JOB']; ?>',
          '7': '<?php echo $text['TOOL_RUNNING']; ?>',
          '8': '<?php echo $text['TOOL_TRIGGER']; ?>',
          '9': '<?php echo $text['REVERSE']; ?>',
          '10': '<?php echo $text['UDEFINE1']; ?>',
          '11': '<?php echo $text['UDEFINE2']; ?>',
          '12': '<?php echo $text['SYS_READY']; ?>',
        };
      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cell = row.getElementsByTagName("td")[0];
        var optionValue = cell.innerHTML;
        cell.innerHTML = formData[cell.innerHTML];
      }
      //end 調整顯示文字

      //reset radio and select
      $('input[name="Input_New"]').prop('checked', false);
      $('#event_select').prop('selectedIndex',0);
      document.getElementById("event_select").options[0].disabled = true;

    }

    function initial() {
      let rowdata = $('#TableOutput').DataTable().rows().data().toArray();
      var table = document.getElementById("TableOutput");
      var rows = table.getElementsByTagName("tr");
      var selectMenu = document.getElementById("event_select");
      var options = selectMenu.options;
      let formData = {
          '1': '<?php echo $text['OK']; ?>',
          '2': '<?php echo $text['NG']; ?>',
          '3': '<?php echo $text['NG_HIGH']; ?>',
          '4': '<?php echo $text['NG_LOW']; ?>',
          '5': '<?php echo $text['OK_SEQ']; ?>',
          '6': '<?php echo $text['OK_JOB']; ?>',
          '7': '<?php echo $text['TOOL_RUNNING']; ?>',
          '8': '<?php echo $text['TOOL_TRIGGER']; ?>',
          '9': '<?php echo $text['REVERSE']; ?>',
          '10': '<?php echo $text['UDEFINE1']; ?>',
          '11': '<?php echo $text['UDEFINE2']; ?>',
          '12': '<?php echo $text['SYS_READY']; ?>',
        };

        //初始化表格
      var inputs = document.querySelectorAll('[name=Output_Option]');
        inputs.forEach(function(input) {
            input.disabled = false;
            input.checked  = false;
        });
        for (var j = 0; j < options.length; j++) {
            options[j].disabled = false;
        }
      var timeInputs = document.querySelectorAll('input[id^="Time"]');
        timeInputs.forEach(function(input) {
            input.value = '';
        });
      //end 初始化表格

      //依據table中的資料disable欄位
      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cell = row.getElementsByTagName("td")[0];
        var optionValue = cell.innerHTML;
        
        for (var j = 0; j < options.length; j++) {
          if ( formData[options[j].value] === optionValue) {
            options[j].disabled = true;
            break;
          }
        }

        for (var j = 1; j < row.getElementsByTagName("td").length; j++) {
          if (row.getElementsByTagName("td")[j].innerHTML != '') {
            let target = j + 1;
            document.getElementById("output_"+j+"_signal01").disabled = true;
            document.getElementById("output_"+j+"_signal02").disabled = true;
            document.getElementById("output_"+j+"_trigger").disabled = true;
            break;
          }
        }
      }

      //依據table中的資料disable欄位
      //disable radio
      rowdata.forEach(function(value){
        document.getElementById("output_"+value['output_pin']+"_signal01").disabled = true;
        document.getElementById("output_"+value['output_pin']+"_signal02").disabled = true;
        document.getElementById("output_"+value['output_pin']+"_trigger").disabled = true;
      });


    }

    //new job 按下save鍵
    function new_job_output_save(){
        $('#new_job_output_save').prop('disabled', true);
        let event_select = document.getElementById("event_select");
        let event_id = event_select.value;
        let text = event_select.options[event_select.selectedIndex].text;
        let output_pin;
        let option;
        let time = 0;

        if(event_id == -1 ){
            $('#new_job_output_save').prop('disabled', false);
            return 0;
        }
        try{
            let event_option = $('input[name=Output_Option]:checked').val().split('_');
            let sss = $('input[name=Output_Option]:checked').val();
            output_pin = event_option[0];
            option = parseInt(event_option[1]);
            time = document.getElementById("Time"+output_pin).value;
            // console.log(document.getElementById("Time"+output_pin));
        }catch (error){
            $('#new_job_output_save').prop('disabled', false);
            return 0;
        }

        var formData = {
          'job_id': $("#job_id").val(),
          'event_id': event_id,
          'output_pin': output_pin,
          'option': option,
          'time': time,
        };

        let valid_result = true;

        if(valid_result){
            $.ajax({
                type: "POST",
                url: "?url=Outputs/check_job_output_conflict",
                data: {'job_id':$("#job_id").val(),'event_id':event_id},
                dataType: "json",
                encode: true,
            }).done(function (dupli) {//成功且有回傳值才會執行
                $.ajax({
                    type: "POST",
                    url: "?url=Outputs/create_output_event",
                    data: formData,
                    dataType: "json",
                    encode: true,
                    beforeSend: function() {
                        $('#overlay').removeClass('hidden');
                    },
                }).done(function(data) { //成功且有回傳值才會執行
                    $('#overlay').addClass('hidden');
                    $('#new_job_event_save').prop('disabled', false);
                    $('#new_job_output_save').prop('disabled', false);
                    job_output();//reload table
                    document.getElementById('OutputNew').style.display='none'
                    document.getElementById('event_select').disabled = false;
                });
            });

        }else{
            $('#new_job_output_save').prop('disabled', false);    
        }

    }

    function edit_output(job_id,event_id) {
        // body...
        rowIndex = document.querySelector("#TableOutput tr.selected").rowIndex;
        let rowdata = $('#TableOutput').DataTable().row(rowIndex-1).data();        
        let on_off = rowdata.wave;
        let pin_num = rowdata.output_pin;
        // console.log(rowdata);

        //選好 radio 跟 select
        if(on_off == 1){document.getElementById("output_"+pin_num+"_signal01").checked = true;}
        if(on_off == 2){document.getElementById("output_"+pin_num+"_signal02").checked = true;}
        if(on_off == 3){document.getElementById("output_"+pin_num+"_trigger").checked = true;}

        //set time
        document.getElementById("Time"+pin_num).value = rowdata.wave_on;
        document.getElementById("Time"+pin_num).disabled = false;

        // document.getElementById("output_"+pin_num+"_"+on_off).checked = true;
        document.getElementById("output_"+pin_num+"_signal01").disabled = false;
        document.getElementById("output_"+pin_num+"_signal02").disabled = false;
        document.getElementById("output_"+pin_num+"_trigger").disabled = false;
        document.getElementById('OutputNew').style.display='block';

        // $('#event_select').prop('selectedIndex',0);
        document.getElementById('event_select').value = event_id;
        document.getElementById('event_select').disabled = true;

        // document.getElementById("event_select").options[0].disabled = true;
        //radio 跟 select 
        //open modal
        option_ini();

    }

    function copy_output(job_id,) {
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

          document.getElementById('CopyOutput').style.display='block'
        });
    }

    //copy input 按下save鍵
    function copy_output_save(){
        $('#copy_input_save').prop('disabled', true);
        let from_job_id = $("#from_job_id").val();
        let to_job_id = $("#to_job_id").val();

        if(to_job_id != null){
            Swal.fire({
                title: '<?php echo $text['output_replace_notice']; ?>',
                showCancelButton: true,
                confirmButtonText: '<?php echo $text['cover_text'];?>',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                // console.log(result)
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "?url=Outputs/copy_output",
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
                            document.getElementById('CopyOutput').style.display='none'
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

    function delete_output(job_id,event_id) {

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
                  url: "?url=Outputs/delete_output",
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
                    job_output();

                });
            }
        })

    }

    function AlignSubmit(job_id) {
        all_job = document.getElementById('output_alljob').value;
        if(all_job != 0){
            job_id = 0;
            document.getElementById('output_alljob').value = 0;
        }
        $.ajax({
            type: "POST",
            url: "?url=Outputs/output_alljob",
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
                job_output();
            }else{
                location.reload();
            }

        });
    }

    function option_ini() {
        let event_select = document.getElementById("event_select");
        let value = event_select.value;
        
        const action = +event_select.value;
        switch (action) {
          case 7:
          case 8:
          case 9: {
            for (var j = 1; j < 10; j++) {
                document.getElementById("output_"+j+"_signal01").disabled = true;
                document.getElementById("output_"+j+"_signal02").disabled = true;
            }
            break;
          }
          case 10:
          case 11: {
            for (var j = 1; j < 10; j++) {
                document.getElementById("output_"+j+"_signal02").disabled = true;
            }
            break;
          }

          default: {
            for (var j = 1; j < 10; j++) {
                if(document.getElementById("output_"+j+"_trigger").disabled == false ){
                    document.getElementById("output_"+j+"_signal01").disabled = false;
                    document.getElementById("output_"+j+"_signal02").disabled = false;    
                }                
            }
            break;
          }
        }
    }
</script>
<style type="text/css">
    .bigger{

    }
    .bigger{
/*        width: 100%;*/
/*        transition: transform 1.0s;*/
    }
    .bigger:hover{
/*        transform: scale(2.0) translateX(25%);*/
    }
</style>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs();
    document.getElementById("home").disabled = false; //
    document.getElementById("Button_Select").disabled = false; //
    document.getElementById("JobNameSelect").disabled = false; //
    document.getElementById("select_confirm").disabled = false; //
    document.getElementById("select_close").disabled = false; //
  });
</script>
<?php } ?>

<?php require APPROOT . 'views/inc/footer.php'; ?>