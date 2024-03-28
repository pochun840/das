<link rel="stylesheet" href="<?php echo URLROOT; ?>css/main.css" type="text/css">

<div class="container-ms">
    <div class="main-content">
        <div class="center-content w3-center">
            <div style="position: relative;text-shadow:3px 5px 0 #444;" class="wrapper w3-center w3-text-red">
                <div class="buttonbox" style=" top: 0;right: 0;text-align: right;position: absolute; ">
                    <?php foreach(LANGUAGE as $key =>$val){?>
                        <input type="button" name='<?php echo $val[1];?>' id= '<?php echo $val[1];?>'  value="<?php echo $val[0];?>" onclick="language_change()" >
                    <?php } ?>
            
                </div>
                <h1 class="col-ms-3 pt-5" style="font-size: 50px;"><?php echo TITLE_INDEX; ?></h1>
                <div style="text-shadow:2px 2px 0 #444; font-size: 30px" class="text w3-center w3-text-yellow"><?php echo SUBTITLE_INDEX; ?></div>
            </div>

            <div class="button col-ms-3 pt-5">
                <button class="menu-item blue" id="normal_job" style="font-size: 20px" onclick="window.location.href='?url=Jobs/index/normal'" ></button>
                <button class="menu-item red" id="advanced_job" style="font-size: 20px" onclick="window.location.href='?url=Jobs/index/advanced'" ></button>
                <button class="menu-item green" id="io_input" style="font-size: 20px" onclick="window.location.href='?url=Inputs'"></button>
                <button class="menu-item orange" id="io_output" style="font-size: 20px" onclick="window.location.href='?url=Outputs'"></button>
                <br><br>
                <button class="menu-item purple" id="operation" style="font-size: 20px" onclick="window.location.href='?url=Dashboards/operation'"></button>
                <button class="menu-item lightblue" id="data" style="font-size: 20px" onclick="window.location.href='?url=Data'"></button>
                <button class="menu-item pink" id="tool" style="font-size: 20px" onclick="window.location.href='?url=Tools'"></button>
                <button class="menu-item PaleGreen" id="setting" style="font-size: 20px;" onclick="window.location.href='?url=Settings'"></button>
                <br><br>

                <?php if($_SESSION['privilege'] == 'admin'){ ?>
                <div>
                    <?php if($data['agent_type'] == '2'){ ?>
                            <button class="menu-item lime" id="" style="font-size: 24px" onclick="window.location.href='?url=Agents'">Agent</button>
                    <?php } ?>
                            <button class="menu-item indigo" id="download" style="font-size: 24px" onclick="DB_sync('C2D')">Load</button>
                            <button class="menu-item deep-orange" id="upload" style="font-size: 24px;" onclick="DB_sync('D2C')">Save</button>
                </div>
                <?php } ?>
            </div>
        </div>
<script>
    function language_change() {
    var language = event.target.id;
    $.ajax({
      type: "POST",
      url: "?url=Dashboards/change_language",
      data: {'language':language},
      dataType: "json",
      encode: true,
      async: false,//等待ajax完成
    }).done(function (data) {//成功且有回傳值才會執行
        location.reload();
    });
}
    // WEB-iDAS FOR GTCS
    const text = document.querySelector('.text');
    const charArr = text.textContent.split('');

    let dataText = '';
    const arrClass = [];
    const arrNumberRandom = [];

    charArr.forEach((element, index) => {
        if (hasWhiteSpace(element)) {
            dataText += `<span class="letter letter-${index}">&nbsp;</span>`;
        } else {
            dataText += `<span class='letter letter-${index}'>${element}</span>`;
        }
    });

    text.innerHTML = dataText;

    for (let i = 0; i < charArr.length; i++) {
        arrNumberRandom.push(i);
        arrClass.push(`letter-${i}`);
    }
    let delay = 0;
    setTimeout(function () {
        const letters = document.querySelectorAll('.letter');
        for (let i = 0; i < charArr.length; i++) {
            let indexRandom = randomNumber(arrNumberRandom.length);

            const posOfletter = arrNumberRandom[indexRandom];
            const letter = letters[posOfletter];

            letter.style.transitionDelay = `${(delay += 0.01)}s`;
            letter.style.animationDelay = `${(delay += 0.1)}s`;
            letter.classList.add('appear', 'go-down');

            arrNumberRandom.splice(indexRandom, 1);
        }
    }, 1000);

    function randomNumber(length) {
        return Math.floor(Math.random() * length);
    }
    function hasWhiteSpace(str) {
        return str.indexOf(' ') >= 0;
    }

  </script>

    <style>
        #normal_job {
            background: url("<?php echo $text['img_normal_job']; ?>") no-repeat;
        }
        #normal_job:hover {
            background: url("<?php echo $text['img_normal_job_hover']; ?>") no-repeat;
        }
        #advanced_job {
            background: url("<?php echo $text['img_advanced_job']; ?>") no-repeat;
        }
        #advanced_job:hover {
            background: url("<?php echo $text['img_advanced_job_hover']; ?>") no-repeat;
        }
        #io_input {
            background: url("<?php echo $text['img_io_input']; ?>") no-repeat;
        }
        #io_input:hover {
            background: url("<?php echo $text['img_io_input_hover']; ?>") no-repeat;
        }
        #io_output {
            background: url("<?php echo $text['img_io_output']; ?>") no-repeat;
        }
        #io_output:hover {
            background: url("<?php echo $text['img_io_output_hover']; ?>") no-repeat;
        }
        #operation {
            background: url("<?php echo $text['img_operation']; ?>") no-repeat;
        }
        #operation:hover {
            background: url("<?php echo $text['img_operation_hover']; ?>") no-repeat;
        }
        #data {
            background: url("<?php echo $text['img_data']; ?>") no-repeat;
        }
        #data:hover {
            background: url("<?php echo $text['img_data_hover']; ?>") no-repeat;
        }
        #tool {
            background: url("<?php echo $text['img_tool']; ?>") no-repeat;
        }
        #tool:hover {
            background: url("<?php echo $text['img_tool_hover']; ?>") no-repeat;
        }
        #setting {
            background: url("<?php echo $text['img_setting']; ?>") no-repeat;
        }
        #setting:hover {
            background: url("<?php echo $text['img_setting_hover']; ?>") no-repeat;
        }
/*
        #download {
            background: url("../public/img/download.png") no-repeat;
            background-size: cover;
        }
        #download:hover {
            background-color:azure ;
        }
        #upload {
            background: url("../public/img/upload.png") no-repeat;
            background-size: cover;
        }
        #upload:hover {
            background-color:azure ;
        }
*/
    </style>

    <style>
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm, div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
            height: auto;
        }
    </style>
  </div>
</div>