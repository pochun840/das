<?php require APPROOT . 'views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/data.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/flatpickr.min.css" type="text/css">

<script src="<?php echo URLROOT; ?>js/data.js"></script>

<script src="<?php echo URLROOT; ?>js/flatpickr.js"></script>
<script src="<?php echo URLROOT; ?>js/flatpickr_zh-tw.js"></script>
<script src="<?php echo URLROOT; ?>js/flatpickr_zh.js"></script>

<?php 
    if($_SESSION['language'] == 'en-us'){
        $calendar_lang = '';
    }else if($_SESSION['language'] == 'zh-cn'){
        $calendar_lang = 'zh';
    }else if($_SESSION['language'] == 'zh-tw'){
        $calendar_lang = 'zh_tw';
    }else{
        $calendar_lang = '';
    }

  $select_type = array('ALL','OK','NG');   
?>
<style>
th, td
{
    padding: 3px;
    border-bottom: 1px solid #ddd;
}

</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                    <h3><?php echo $text['data']; ?></h3>
                </td>
                <td>
                    <button id="home" class="w3-btn w3-round-large" style="height:50px;padding: 0" onclick="window.location.href='./?url=Dashboards'"> <img src="../public/img/btn_home.png"></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content">
        <div class="center-content">
            <div class="center" style="position: relative; padding-right: 10px">
                <button id="bnt1" name="History_Display" class="button button3 active" onclick="OpenButton('History')"><?php echo $text['data_history'];?></button>
                <button id="bnt2" name="Export_Data_Display" class="button button3" onclick="OpenButton('Exportdata')"><?php echo $text['data_export'];?></button>
                <div style="position:absolute;z-index: 9;right: 1px;top: 10px;">
                    <select id="data_select" class="form-select" onchange="get_type(this)">
                        <?php foreach($select_type as $key1 => $value1){?>
                          <option value="<?php  echo $value1;?>" <?php if($value1 == $data['select_type']){ echo "selected=selected";}?>> <?php  echo $value1;?> </option>
                        <?php }  ?>
          
                    </select>
                </div>
            </div>
            <div id="DataButtonMode">
                <!-- History -->
                <div id="HistoryDisplay">
                    <!-- Data ALL -->
                    <div class="table-container w3-padding" id="fasten_log_all" style="margin-bottom: 10px;">
                        <div class="top-container">
                            <h3 style="margin: 5px;"><?php echo $text['data_history_success'];?></h3>
                        </div>
                        <table id="fasten_log_all_table" width="100%" style="text-align: center; font-size: 1.8vmin; line-height: 1.5">
                            <thead>
                                <tr>
                                    <th><?php echo $text['column_no'];?></th>
                                    <th><?php echo $text['column_datetime'];?></th>
                                    <th><?php echo $text['job_name'];?></th>
                                    <th><?php echo $text['seq_name'];?></th>
                                    <th><?php echo $text['torque'];?></th>
                                    <th><?php echo $text['column_unit'];?></th>
                                    <th><?php echo $text['angle'];?></th>
                                    <th><?php echo $text['column_total'];?></th>
                                    <th><?php echo $text['column_count'];?></th>
                                    <th><?php echo $text['column_status'];?></th>
                                </tr>
                            </thead>
                            <tbody id="" class="border-bottom" style="text-align: center; font-size: 1.8vmin; line-height: 1.8">
                                <?php
                                    foreach($data['Data_info'] as $key => $value) {?>
                                        <tr>
                                            <td><?php echo $value['system_sn'];?></td>
                                            <td><?php echo $value['data_time'];?></td>
                                            <td><?php echo $value['job_name'];?></td>
                                            <td><?php echo $value['sequence_name'];?></td>
                                            <td><?php echo $value['fasten_torque'];?></td>
                                            <td class='funit'><?php echo $value['torque_unit'];?></td>
                                            <td><?php echo $value['fasten_angle'];?></td>
                                            <td><?php echo $value['max_screw_count'];?></td>
                                            <td><?php echo $value['last_screw_count'];?></td>
                                            <td class='fstatus'><?php echo $value['fasten_status'];?></td>
                                        </tr>
                                   <?php }?>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Export Data -->
                <div id="ExportdataDisplay" style="display:none;">
                    <div class="data-export" style="background-color: #F2F1F1;">
                        <h2><?php echo $text['data_export'];?></h2>
                        <div class="row">
                          <div class="col-sm-6">
                            <div style="max-width: 450px;margin: auto;text-align: center;">
                            <label for="start" style="font-size:20px;">📅<?php echo $text['start_date'];?>：</label>
                            <div class="mb-3" >
                              <input type="text" id="start_date" placeholder="Select datetime" class="form-control" style="background-color: #fff;display:none;" >
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div style="max-width: 450px;margin: auto;text-align: center;">
                            <label for="start" style="font-size:20px;">📅<?php echo $text['end_date'];?>：</label>
                            <div class="mb-3" >
                              <input type="text" id="end_date" placeholder="Select datetime" class="form-control" style="background-color: #fff;display: none;" >
                            </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <button class="btn-export" onclick="exportData()"><?php echo $text['data_export'];?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    $(document).ready(function () {
        const fasten_status = [
          { index: 0, status: "<?php echo $text['fasten_status_0']; ?>", color: "" },
          { index: 1, status: "<?php echo $text['fasten_status_1']; ?>", color: "" },
          { index: 2, status: "<?php echo $text['fasten_status_2']; ?>", color: "" },
          { index: 3, status: "<?php echo $text['fasten_status_3']; ?>", color: "" },
          { index: 4, status: "<?php echo $text['fasten_status_4']; ?>", color: "green" },
          { index: 5, status: "<?php echo $text['fasten_status_5']; ?>", color: "yellow" },
          { index: 6, status: "<?php echo $text['fasten_status_6']; ?>", color: "yellow" },
          { index: 7, status: "<?php echo $text['fasten_status_7']; ?>", color: "red" },
          { index: 8, status: "<?php echo $text['fasten_status_8']; ?>", color: "red" },
          { index: 9, status: "<?php echo $text['fasten_status_9']; ?>", color: "" },
          { index: 10, status: "<?php echo $text['fasten_status_10']; ?>", color: "" },
          { index: 11, status: "<?php echo $text['fasten_status_11']; ?>", color: "" },
          { index: 12, status: "<?php echo $text['fasten_status_12']; ?>", color: "" },
          { index: 13, status: "<?php echo $text['fasten_status_13']; ?>", color: "" },
          { index: 14, status: "<?php echo $text['fasten_status_14']; ?>", color: "" },
          { index: 15, status: "<?php echo $text['fasten_status_15']; ?>", color: "" },
          { index: 16, status: "<?php echo $text['fasten_status_16']; ?>", color: "" },
          { index: 17, status: "<?php echo $text['fasten_status_17']; ?>", color: "" },
          { index: 18, status: "<?php echo $text['fasten_status_18']; ?>", color: "" },
          { index: 19, status: "<?php echo $text['fasten_status_19']; ?>", color: "" },
        ];

        const fstatusCells = document.querySelectorAll('.fstatus');

        // 對每個欄位進行內容調整
        fstatusCells.forEach(cell => {
          let currentStatus = parseInt(cell.textContent, 10);
          let adjustedStatus = fasten_status[currentStatus].status;
          cell.textContent = adjustedStatus;
        });


        const fasten_unit = [
          { index: 0, status: "<?php echo $text['unit_status_0']; ?>", color: "" },
          { index: 1, status: "<?php echo $text['unit_status_1']; ?>", color: "" },
          { index: 2, status: "<?php echo $text['unit_status_2']; ?>", color: "" },
          { index: 3, status: "<?php echo $text['unit_status_3']; ?>", color: "" },
        ];

        const funitCells = document.querySelectorAll('.funit');

        // 對每個欄位進行內容調整
        funitCells.forEach(cell => {
          let currentUnit = parseInt(cell.textContent, 10);
          let adjustedUnit = fasten_unit[currentUnit].status;
          cell.textContent = adjustedUnit;
        });

        // $('#fasten_log_all_table').DataTable({
        //     paging: false,
        //     searching: false,
        //     bInfo : false,
        //     // "ordering": false,
        //     // "bPaginate": false,
        //     "dom": "frti",
        //     // "pageLength": 15,
        //     });

    });

    function exportData() {
        let start_date = document.getElementById('start_date').value;
        let end_date = document.getElementById('end_date').value;
        let valid_flag = true;

        if(start_date > end_date){
            Swal.fire('開始日期需小於結束日期', '', 'warning')
            valid_flag = false;
        }
        if(start_date == '' || end_date == ''){
            Swal.fire('請選擇開始日期與結束日期', '', 'warning')
            valid_flag = false;
        }
        
        if(valid_flag){

        // 構建 AJAX 請求的 URL，將時間參數串入
        var url = '?url=Data/exportData';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'start_date': start_date,
                'end_date': end_date
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                // console.log(data);
                const reader = new FileReader();
                // This fires after the blob has been read/loaded.
                reader.addEventListener('loadend', (e) => {
                  const text = e.srcElement.result;
                  // console.log(text);
                  if(text.trim() === 'false'){
                    Swal.fire('單次匯出不得超過10000筆', '', 'warning')
                  }else{
                    var blob = new Blob([data], { type: 'text/csv' });
                    var downloadLink = document.createElement('a');
                    downloadLink.href = URL.createObjectURL(blob);
                    downloadLink.download = 'your_csv_file_name.csv';
                    downloadLink.click();
                  }
                });
                // Start reading the blob as text.
                reader.readAsBinaryString(data);

                
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        }
    }

    const moonLanding = new Date();
    console.log(moonLanding.getFullYear())
    let yy = moonLanding.getFullYear();
    flatpickr("#start_date,#end_date", {
      enableTime: true,
      static: true,
      inline:true,
      dateFormat: "Y-m-d H:i",
      locale: "<?php echo $calendar_lang; ?>", // 設定語言為繁體中文
      disableMobile: "true",
      // minDate: String(yy),
      maxDate: String(yy)+'-12-31',
      // maxDate: new Date().fp_incr(0) // 14 days from now
    });
    

    // document.getElementsByName("daterange")[0].value
    // let clickEvent = new Event('click');

    // document.getElementsByName("daterange")[0].dispatchEvent(clickEvent);


    </script>
    <style type="text/css">
        .input-group>.flatpickr-calendar,.input-group>.flatpickr-calendar>.flatpickr-innerContainer,.dayContainer{
            width: 100%;
        }
        .data-export {
          max-width: 800px;
          margin: 0 auto;
          padding: 20px;
          background-color: #f8f8f8;
          border-radius: 5px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .data-export h2 {
          text-align: center;
          margin-bottom: 20px;
        }

        label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
        }

        .btn-export {
          display: block;
          width: 50%;
          margin: auto;
          padding: 10px;
          font-size: 16px;
          color: #fff;
          background-color: #007bff;
          border: none;
          border-radius: 3px;
          cursor: pointer;
        }

        .btn-export:hover {
          background-color: #0056b3;
        }

 
    </style>
</div>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs();
    document.getElementById("home").disabled = false; 
    document.getElementById("data_select").disabled = false; 
  });
</script>


<?php } ?>

<?php require APPROOT . 'views/inc/footer.php'; ?>
