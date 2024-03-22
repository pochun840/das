
<?php require APPROOT . 'views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/operation_manager.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/c3.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/fontawesome5.12.1.css" type="text/css">
<!-- <script async="" src="<?php echo URLROOT; ?>js/all.min.js"></script> -->
<script src="<?php echo URLROOT; ?>js/d3_v5.js"></script>
<script src="<?php echo URLROOT; ?>js/c3.min.js"></script>
<script src="<?php echo URLROOT; ?>js/papaparse.min.js"></script>


<style type="text/css">
    @font-face
    {
      font-family: 'LED字型';
      src: url('<?php echo URLROOT; ?>font/Petitinho.ttf') format('truetype');
    }
    .led-number
    {
 /*      font-family: 'LED字型', sans-serif;*/
    }

    /* 在手機旋轉時套用的 CSS 樣式 */
    @media screen and (orientation: landscape) and (max-height: 450px) {
      /* 手機為橫向旋轉狀態時的 CSS */
      /* 在此設定您的 CSS 樣式 */
        .panel-container
        {
            height: 60%!important;margin: 5px;
        }

        .w3-container, .w3-panel
        {
            padding: 0.01em 10px;
        }

        .message-font
        {
            font-size: 4vmin!important;
        }

        .w3-panel
        {
            margin-top: 5px!important;
        }

        .table-font
        {
            font-size: 3vmin!important;
        }

        .p1{  }
        .p2{  }
        .p3{  }
        .p4{  }



    }

    .panel-container
    {
        height: 80%;margin: 5px;
    }

    @media screen and (orientation: portrait) and (max-width: 450px)
    {
      /* 手機為直向旋轉狀態時的 CSS */
      /* 在此設定您的 CSS 樣式 */
     /* .panel-container{
        height: 80%;margin: 5px;
       }*/
       .message-font
       {
            font-size: 4vmin!important;
        }
        .table-font
        {
            font-size: 3vmin!important;
        }

        .p1{  }
        .p2{  }
        .p3{  }
        .p4{  }
    }


</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                    <h3 style="font-size:4vmin"><?php echo $text['operation_result']; ?></h3>
                </td>
                <td>
                    <button class="w3-btn w3-round-large" style="height:50px;padding: 0; " onclick="window.location.href='?url=Dashboards'"> <img src="../public/img/btn_home.png"></button>
                </td>
                <td style="display: none;">
                    <input type="text" id="graph_type" value="1" style="display: none;" disabled>
                    <input type="text" id="torque_unit" value="1" style="display: none;" disabled>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <div id="Job_Operation">
            <table class="w3-table w3-dark-grey table-font">
                <tr>
                    <td>
                        <label style="color: #FFF; font-weight: bold; font-size: 18px" for="Job_Name"><?php echo $text['job']; ?> :</label>
                        <input style="height:35px; color: #000; font-size: 16px" type="text" id="Job_Name" name="Job_Name" size="10" maxlength="15" value="" disabled>
                    </td>
                    <td>
                        <label style="color: #FFF; font-weight: bold; font-size: 18px" for="Seq_Name"><?php echo $text['sequence']; ?> :</label>
                        <input style="height:35px; color: #000; font-size: 16px" type="text" id="Seq_Name" name="Seq_Name" size="10" maxlength="15" value="" disabled>
                    </td>
                    <td>
                        <label style="color: #FFF; font-weight: bold; font-size: 18px" for="Screws"><?php echo $text['screws']; ?> :</label>
                        <input style="height:35px; color: #000; text-align: center; font-size: 16px" type="text" id="Screws" name="Screws" size="4" maxlength="5" value="" disabled>
                    </td>
                </tr>
            </table>
        </div>

        <div class="w3-display-container panel-container" style="background-color: #D4D4BF">
            <div class="w3-display-topleft p1" style="width:48%; height:25%; background-color: #CDC5BF">
                <div class="w3-display-topmiddle w3-panel w3-border-top w3-border-bottom w3-border-red w3-center" style="font-size: 3vmin; font-weight: bold; width: 70%"><?php echo $text['final_torque']; ?><span id="torque_unit_span"></span></div>
                <div id="Target_Torque" class="w3-display-middle led-number torque-font" style="font-size: 8vmin;top: 60%;">-</div>
            </div>
            <div class="w3-display-topright p2" style="width:50%; height:25%; background-color: #B5B5B5">
                <div class="w3-display-topmiddle w3-panel w3-border-top w3-border-bottom w3-border-red w3-center" style="font-size: 3vmin; font-weight: bold; width: 70%"><?php echo $text['final_angle']; ?></div>
                <div id="Target_Angle" class="w3-display-middle led-number angle-font" style="font-size: 8vmin;top: 60%;">-</div>
            </div>
            <div id="p3" class="p3" style="width:48%; height:25%; background-color: #B5B5B5;position: absolute; left: 0; top: 26%;">
                <div id="p3_title" class="w3-display-topmiddle w3-panel w3-center" style="font-size: 3vmin; font-weight: bold; width: 70%;border-top: 1px solid; border-bottom: 1px solid;"><?php echo $text['final_result']; ?></div>
                <div id="Torque_Result" class="w3-display-middle result-font" style="font-size: 7vmin;width: 80%;text-align: center;top: 60%;">-</div>
            </div>
            <div class="p4" style="width:50%; height:25%; background-color: #CDC5BF;position: absolute; right: 0; top: 26%;">
                <div class="w3-display-topmiddle w3-panel w3-border-top w3-border-bottom w3-border-red w3-center" style="font-size: 3vmin; font-weight: bold; width: 70%"><?php echo $text['final_message']; ?></div>
                <div id="Message" class="w3-display-middle message-font" style="font-size: 2.5vmax;width: 100%;text-align: center; line-height: 1.2;top: 60%;">-</div>
            </div>

            <div id="graph" class="row p5" style="margin: 0px;padding: 0;position: absolute; left: 10%;  top: 52%;width: 90%;">
                <div class="col-lg-12" style="padding: 0;">
                    <div id="chart" style="background-color:white; height: auto"></div>
                </div>
            </div>

            <div class="p6" style="margin: 0px;padding: 0;position: absolute; left: 0; top:52%;width: 10%;text-align: center;">
                <ul class="nav nav-pills" id="graphTab" role="tablist">
                  <li class="nav-item" style="background-color: grey;border-radius: 0.25rem;width: 98%;margin-bottom: 5px;">
                    <a class="nav-link active" style="color: white; font-size: 16px"  href="#" onclick="G_type(1)"><?php echo $text['torque'].' '.$text['time']; ?></a>
                  </li>
                  <li class="nav-item" style="background-color: grey;border-radius: 0.25rem;width: 98%;margin-bottom: 5px;">
                    <a class="nav-link" style="color: white; font-size: 16px" href="#" onclick="G_type(2)"><?php echo $text['angle'].' '.$text['time']; ?></a>
                  </li>
                  <li class="nav-item" style="background-color: grey;border-radius: 0.25rem;width: 98%;margin-bottom: 5px;">
                    <a class="nav-link" style="color: white; font-size: 16px" href="#" onclick="G_type(3)"><?php echo $text['rpm'].' '.$text['time']; ?></a>
                  </li>
                  <li class="nav-item" style="background-color: grey;border-radius: 0.25rem;width: 98%;margin-bottom: 5px;">
                    <a class="nav-link" style="color: white; font-size: 16px" href="#" onclick="G_type(4)"><?php echo $text['torque'].' '.$text['angle']; ?></a>
                  </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    let chart =c3.generate({bindto: '#chart',data: { columns: [ ['data1'], ], },});

    const TorqueUnit = [
        { index: 0, status: "<?php echo $text['unit_status_0']; ?>", color: "" },
        { index: 1, status: "<?php echo $text['unit_status_1']; ?>", color: "" },
        { index: 2, status: "<?php echo $text['unit_status_2']; ?>", color: "" },
        { index: 3, status: "<?php echo $text['unit_status_3']; ?>", color: "" },
    ];

    $(document).ready(function() {
        window.scrollTo(0,0);

        const fasten_status = [
          { index: 0, status: "Initialize", color: "" },
          { index: 1, status: "Tool Ready", color: "" },
          { index: 2, status: "Tool running", color: "" },
          { index: 3, status: "Reverse", color: "" },
          { index: 4, status: "OK", color: "green" },
          { index: 5, status: "OK-SEQ", color: "yellow" },
          { index: 6, status: "OK-JOB", color: "yellow" },
          { index: 7, status: "NG", color: "red" },
          { index: 8, status: "NG Stop", color: "red" },
          { index: 9, status: "Setting", color: "" },
          { index: 10, status: "EOC", color: "" },
          { index: 11, status: "C1", color: "" },
          { index: 12, status: "C2", color: "" },
          { index: 13, status: "C4", color: "" },
          { index: 14, status: "C5", color: "" },
          { index: 15, status: "BS", color: "" },
        ];

        const error_message = [
          { index: 0, status: "NO Error", color: "" },
          { index: 1, status: "<?php echo $error_message['ERR_CONT_TEMP'] ?>", color: "" },
          { index: 2, status: "<?php echo $error_message['ERR_MOT_TEMP'] ?>", color: "" },
          { index: 3, status: "<?php echo $error_message['ERR_MOT_CURR'] ?>", color: "" },
          { index: 4, status: "<?php echo $error_message['ERR_MOT_PEAK_CURR'] ?>", color: "" },
          { index: 5, status: "<?php echo $error_message['ERR_HIGH_TORQUE'] ?>", color: "" },
          { index: 6, status: "<?php echo $error_message['ERR_DEADLOCK'] ?>", color: "" },
          { index: 7, status: "<?php echo $error_message['ERR_PROC_MINTIME'] ?>", color: "" },
          { index: 8, status: "<?php echo $error_message['ERR_PROC_MAXTIME'] ?>", color: "" },
          { index: 9, status: "<?php echo $error_message['ERR_ENCODER'] ?>", color: "" },
          { index: 10, status: "<?php echo $error_message['ERR_HALL'] ?>", color: "" },
          { index: 11, status: "<?php echo $error_message['ERR_BUSVOLT_HIGH'] ?>", color: "" },
          { index: 12, status: "<?php echo $error_message['ERR_BUSVOLT_LOW'] ?>", color: "" },
          { index: 13, status: "<?php echo $error_message['ERR_PROC_NA'] ?>", color: "" },
          { index: 14, status: "<?php echo $error_message['ERR_STEP_NA'] ?>", color: "" },
          { index: 15, status: "<?php echo $error_message['ERR_DMS_COMM'] ?>", color: "" },
          { index: 16, status: "<?php echo $error_message['ERR_FLASH'] ?>", color: "" },
          { index: 17, status: "<?php echo $error_message['ERR_FRAM'] ?>", color: "" },
          { index: 18, status: "<?php echo $error_message['ERR_HIGH_ANGLE'] ?>", color: "" },
          { index: 19, status: "<?php echo $error_message['ERR_PROTECT_CIRCUIT'] ?>", color: "" },
          { index: 20, status: "<?php echo $error_message['ERR_SWITCH_CONFIG'] ?>", color: "" },
          { index: 21, status: "<?php echo $error_message['ERR_STEP_NOT_REC'] ?>", color: "" },
          { index: 22, status: "<?php echo $error_message['ERR_TMD_FRAM'] ?>", color: "" },
          { index: 23, status: "<?php echo $error_message['ERR_LOW_TORQUE'] ?>", color: "" },
          { index: 24, status: "<?php echo $error_message['ERR_LOW_ANGLE'] ?>", color: "" },
          { index: 25, status: "<?php echo $error_message['ERR_PROC_NOT_FINISH'] ?>", color: "" },
          { index: 26, status: "", color: "" },
          { index: 27, status: "", color: "" },
          { index: 28, status: "", color: "" },
          { index: 29, status: "", color: "" },
          { index: 30, status: "", color: "" },
          { index: 31, status: "", color: "" },
          { index: 32, status: "<?php echo $error_message['SEQ_COMPLETED'] ?>", color: "" },
          { index: 33, status: "<?php echo $error_message['JOB_COMPLETED'] ?>", color: "" },
          { index: 34, status: "<?php echo $error_message['WORKPIECE_RECOVERY'] ?>", color: "" },
        ];

        let isSendingRequest = false;
        let firsttime = true;
        setInterval(function() {
            // 發送 AJAX 請求到服務器
            if (isSendingRequest) {
              // 如果正在發送，不執行新的请求
              return;
            }
            $.ajax({
              url: '?url=Dashboards/get_last_data', // 指向服務器端檢查更新的 PHP 腳本
              method: 'GET',
              success: function(response) {
                // 處理服務器返回的響應
                // if (response.updated) {
                if (response.updated || firsttime) {
                  // 數據庫有更新，處理更新的數據
                  var data = response.data;
                  let job_text = ''+data.job_id+' ,'+data.job_name;
                  let seq_text = ''+data.sequence_id+' ,'+data.sequence_name;
                  let screws_text = data.last_screw_count+'/'+data.max_screw_count;
                  let Torque_text = data.fasten_torque;
                  let Angle_text = data.fasten_angle;
                  let Result_text = fasten_status[data.fasten_status].status;
                  let Result_color = fasten_status[data.fasten_status].color;
                  let Message_text = error_message[data.error_message].status;

                  $('#Job_Name').val(job_text);
                  $('#Seq_Name').val(seq_text);
                  $('#Screws').val(screws_text);
                  $('#Target_Torque').text(Torque_text);
                  $('#Target_Angle').text(Angle_text);
                  $('#Torque_Result').text(Result_text);
                  // $('#Torque_Result').css("background-color", Result_color);
                  $('#p3_title').css("border-color", "black");
                  // $('#p3_title').attr('style', 'border-color: black !important');
                  $("#p3_title").css({"border-color": "yellow !important"});


                  $('#p3').css("background-color", Result_color);
                  $('#Message').text(Message_text);
                  //調整字體大小

                  // 執行相應的操作，比如顯示更新的數據
                  // console.log('數據庫有更新:', data);
                  firsttime = false;

                  draw(data.system_sn);
                  //因應torque_unit調整介面文字
                  document.getElementById('torque_unit').value = data.torque_unit;
                  document.getElementById('torque_unit_span').innerHTML = '(' + TorqueUnit[data.torque_unit].status + ')';
                  
                }
                isSendingRequest = false;
              },
              complete: function(XHR, TS) { 
                XHR = null;
                // console.log("执行一次"); 
                },
              error:function(xhr, status, error){
                // console.log("fail");
              }
            });
        }, 500); // 每隔5秒發送一次請求，可以根據需要調整時間間隔
    });

</script>

<script>
const sec = [];
const torque = [];
const angle = [];
const rpm = [];
const power = [];
// const chart =c3.generate({bindto: '#chart'});


function draw(sn = 0) {
    let clientHeight = document.getElementById('graph').clientHeight;
    let data_url = '?url=Dashboards/get_datalog&sn='+sn;
    let graph_type = document.getElementById('graph_type').value;
    Papa.parse(data_url, {
        download: true,
        complete: results => {
            sec.length = 0;
            torque.length = 0;
            angle.length = 0;
            rpm.length = 0;
            power.length = 0;
            sec[0] = 'sec';
            torque[0] = 'torque';
            angle[0] = 'angle';
            rpm[0] = 'rpm';
            power[0] = 'power';
            for (let j=0; j<results.data.length; j++) {
                sec.push(results.data[j][0]);
                torque.push(results.data[j][1]);
                angle.push(results.data[j][2]);
                rpm.push(results.data[j][3]);
                power.push(results.data[j][4]);
            }
            G_type(graph_type);
            $('#graphTab a:eq('+ (+graph_type-1) +')').tab('show');//active ul first
        }
    })
}

function G_type(type) {
    let torque_unit = document.getElementById('torque_unit').value;

    document.getElementById('graph_type').value = type;//紀錄目前的選項，下次進來就會使用最後一次使用的設定

    let clientHeight = document.getElementById('graph').clientHeight;
    let pattern = ['#1f77b4','#1f77b4', '#aec7e8', '#ff7f0e', '#ffbb78', '#2ca02c']

    let x_axis = 'sec';
    let x_data = angle;
    let y_data = torque;
    let x_label = 'angle';
    let y_label = 'Nm';
    y_label = TorqueUnit[torque_unit].status;

    if(type == 1){//torque time
        x_data = sec;
        y_data = torque;
        x_label = 'ms';
        y_label = TorqueUnit[torque_unit].status;
    }else if(type == 2){// angle time
        x_data = sec;
        y_data = angle;
        x_label = 'ms';
        y_label = 'angle'
    }else if(type == 3){// rpm tmie
        x_data = sec;
        y_data = rpm;
        x_label = 'ms';
        y_label = 'rpm'
    }else if(type == 4){// torque angle
        x_axis = 'angle';
        x_data = angle;
        y_data = torque;
        x_label = 'angle';
        y_label = TorqueUnit[torque_unit].status;
    }

    chart.destroy();
    chart = c3.generate({
                size: {
                    height: clientHeight,
                    // width: 480
                },
                subchart: {
                    show: true
                },
                bindto: '#chart',
                data: {
                      x: x_axis,
                      columns: [
                        x_data,
                        y_data
                      ],
                      type: 'spline'
                    },
                axis: {
                    x: {
                        label: x_label,
                    },
                    y: {
                        label: y_label
                    }
                },
                color: {
                    pattern: [pattern[type]]
                }
            });
}

$('#graphTab a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})
// draw();
</script>





<?php require APPROOT . 'views/inc/footer.php'; ?>