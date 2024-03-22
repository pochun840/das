$(document).ready(function() {

  var Delay_Time = document.getElementById('Delay_Time');
  var Target_Torque = document.getElementById('Target_Torque');
  var Torque_Window_Add = document.getElementById('Torque_Window_Add');
  var Target_Angle = document.getElementById('Target_Angle');
  var Angle_Window_Add_A = document.getElementById('Angle_Window_Add_A');
  

  //前端即時限制輸入
  // Delay_Time.addEventListener('input', function() {
  //     var value = Delay_Time.value.trim();
  //     // 移除非数字和小数点之外的字符
  //     value = value.replace(/[^0-9.]/g, '');
  //     // 限制小数点后只能有一位数字
  //     var parts = value.split('.');
  //     if (parts.length > 1) {
  //         parts[1] = parts[1].substring(0, 1);
  //         value = parts.join('.');
  //     }
  //     Delay_Time.value = value;
  //     if (parseFloat(value) < 0 || parseFloat(value) > 10) {
  //         Delay_Time.value = "";
  //     }
  // });

  //即時將target torque 寫到 Torque window
  Target_Torque.addEventListener('input', function() {
      var value = Target_Torque.value.trim();
      Torque_Window_Add.value = value;
  });

  //即時將target angle 寫到 angle window
  Target_Angle.addEventListener('input', function() {
      var value = Target_Angle.value.trim();
      Angle_Window_Add_A.value = value;
  });


  //Torque monitor mode
  $('input[type=radio][name="Monitor_Option"]').on('change', function() {
      // console.log($(this).val())
      let monitor_angle = $("input[name=Monitor_Angle_Option]:checked").val();
      let monitor_mode = $(this).val();
      if (monitor_mode == 1) { // Hi-Lo
        //disable name="Torque_Window_Subtraction"
        $("#Torque_Window_Subtraction").prop('disabled', true);
        $("#Torque_Window_tr").hide();
        //show Hi_Torque tr
        $("#Hi_Torque_tr").show();
        //show Lo_Torque tr
        $("#Lo_Torque_tr").show();

        $("#Angle_Window_tr").hide();

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

        if(monitor_angle == 1){
            $("#Angle_Window_tr").show();
        }
        
      }
  })

  //Torque monitor angle mode
  $('input[type=radio][name="Monitor_Angle_Option"]').on('change', function() {
      // console.log($(this).val())
      let monitor_mode = $("input[name=Monitor_Option]:checked").val();
      let monitor_angle = $(this).val();
      if (monitor_angle == 1) { // ON
          //show Over Angle Stop tr
        $("#Over_Ang_Stop_tr").show();
        if(monitor_mode == 1){ // Hi-Lo
          //show Over Angle Stop tr
          $("#Angle_Window_tr").hide();
          //show Hi_Angle tr
          $("#Hi_Angle_tr").show();
          //show Lo_Angle tr
          $("#Lo_Angle_tr").show();
        }
        if(monitor_mode == 0){ // Window
          //show Angle_Window_tr tr
          $("#Angle_Window_tr").show();
        }

      }
      if (monitor_angle == 0) { // OFF
          //hide Over Angle Stop tr
          $("#Angle_Window_tr").hide();
          //hide Hi_Angle tr
          $("#Hi_Angle_tr").hide();
          //hide Lo_Angle tr
          $("#Lo_Angle_tr").hide();

          $("#Over_Ang_Stop_tr").hide();

      }
  })

  //Angle monitor mode
  $('input[type=radio][name="Monitor_Option_A"]').on('change', function() {
      // console.log($(this).val())
      let monitor_mode = $(this).val();
      if (monitor_mode == 1) { // Hi-Lo
        //show Hi_Torque tr
        $("#Hi_Torque_A_tr").show();
        //show Lo_Torque tr
        $("#Lo_Torque_A_tr").show();
        //show Hi_Angle tr
        $("#Hi_Angle_A_tr").show();
        //show Lo_Angle tr
        $("#Lo_Angle_A_tr").show();

        $("#Torque_Window_A_tr").hide();
        $("#Angle_Window_A_tr").hide();


      }
      if (monitor_mode == 0) { // Window
        //hide Hi_Torque tr
        $("#Hi_Torque_A_tr").hide();
        //hide Lo_Torque tr
        $("#Lo_Torque_A_tr").hide();
        //hide Hi_Angle tr
        $("#Hi_Angle_A_tr").hide();
        //hide Lo_Angle tr
        $("#Lo_Angle_A_tr").hide();

        $("#Torque_Window_A_tr").show();
        $("#Angle_Window_A_tr").show();
        
      }
  })


// 选中所有输入框
    var inputs = document.querySelectorAll('input');
    let Tool_Max_Torque = parseFloat(document.getElementById('tool_maxtorque').value);
    let Tool_Max_RPM = parseFloat(document.getElementById('tool_maxrpm').value);
    // console.log(Tool_Max_Torque);
    // console.log(Tool_Max_RPM);

    // 遍历输入框并添加即时验证和值替换
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var inputValue = input.value.trim();

            // 根据输入框的 id 执行相应的验证逻辑和值替换
            switch (input.id) {
                                
                case 'Target_Angle':
                    // 限制1~30600
                    // if (!/^\d{1,5}$/.test(inputValue) || inputValue < 1 || inputValue > 30600) {
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Angle_A':
                    // let Target_Angle_A_Value = parseFloat(document.getElementById('Target_Angle_A').value);
                    // 限制1~30600
                    // if (!/^\d{1,5}$/.test(inputValue) || inputValue < 1 || inputValue > 30600) {
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Lo_Angle_A':
                    let High_Angle_A_Value = parseFloat(document.getElementById('Hi_Angle_A').value);
                    // 限制0~305999
                    // if (!/^\d{1,5}$/.test(inputValue) || inputValue < 0 || inputValue > High_Angle_A_Value ) {
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Torque_A':
                    // 限制輸入4位數和小數點後兩位，大於Target_Torque
                    var targetTorque = Tool_Max_Torque;
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ||  parseFloat(inputValue) > parseFloat(Tool_Max_Torque) ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';  //
                    }
                    break;
                case 'Lo_Torque_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Threshold_Torque_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque且大於Downshift_Torque
                    var targetTorque = parseFloat(document.getElementById('Hi_Torque_A').value);
                    var downshiftTorque = parseFloat(document.getElementById('Downshift_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(parseFloat(inputValue)) || parseFloat(inputValue) >= parseFloat(targetTorque) || parseFloat(inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Downshift_Torque_A':
                    // 不可大於Target_Torque，限制輸入4位數和小數點後兩位
                    var Threshold_Torque_A_Value = parseFloat(document.getElementById('Threshold_Torque_A').value);
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;

                //--------------------------------------------------------------
                case 'RPM':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    // if (!/^\d{0,4}$/.test(inputValue) || inputValue < 0 || inputValue > Tool_Max_RPM) {
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                        // input.value = inputValue.substr(0, 4);
                    }
                    break;
                case 'RPM_A':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    // if (!/^\d{0,4}$/.test(inputValue) || inputValue < 0 || inputValue > Tool_Max_RPM) {
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Delay_Time_A':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    // if (!/^\d{0,4}$/.test(inputValue) || inputValue < 0 || inputValue > Tool_Max_RPM) {
                    if (!/^\d{0,4}(\.\d{0,1})?$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Delay_Time_T':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    // if (!/^\d{0,4}$/.test(inputValue) || inputValue < 0 || inputValue > Tool_Max_RPM) {
                    if (!/^\d{0,4}(\.\d{0,1})?$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Target_Torque':
                    // 限制輸入4位數和小數點後兩位
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) > Tool_Max_Torque ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue)  ) {
                        input.value = '';
                        // input.classList.add("is-invalid");
                    }else{
                      // input.classList.remove("is-invalid");
                    }
                    break;
                case 'Joint_OffSet':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '0';
                    }
                    break;
                case 'Hi_Torque':
                    // 限制輸入4位數和小數點後兩位，大於Target_Torque
                    var targetTorque = Tool_Max_Torque;
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ||  parseFloat(inputValue) > parseFloat(Tool_Max_Torque) ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';  //
                    }
                    break;
                case 'Lo_Torque':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Torque_Window_Subtraction':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ||  (targetTorque - inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Angle_Window_Add':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,5}?$/.test(inputValue) || inputValue  > 30600 ) {
                    if (!/^\d{0,5}?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Angle_Window_Subtraction':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var Angle_Window_Add_value = parseFloat(document.getElementById('Angle_Window_Add').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,5}?$/.test(inputValue) || (parseFloat(inputValue) + Angle_Window_Add_value) > 30600 ||  (Angle_Window_Add_value - inputValue) < 0 ) {
                    if (!/^\d{0,5}?$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Angle':
                    // let Target_Angle_A_Value = parseFloat(document.getElementById('Target_Angle_A').value);
                    // 限制1~30600
                    // if (!/^\d{1,5}$/.test(inputValue) || inputValue < 1 || inputValue > 30600) {
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Lo_Angle':
                    let Hi_Angle_Value = parseFloat(document.getElementById('Hi_Angle').value);
                    // 限制0~305999
                    // if (!/^\d{1,5}$/.test(inputValue) || inputValue < 0 || inputValue > Hi_Angle_Value ) {
                    if (!/^\d{1,5}$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Torque_Window_Add_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || inputValue < 0 || parseFloat(inputValue) > parseFloat(Tool_Max_Torque)  ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Torque_Window_Subtraction_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var Torque_Window_Add_A_value = parseFloat(document.getElementById('Torque_Window_Add_A').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || (parseFloat(inputValue) + parseFloat(Torque_Window_Add_A_value)) > parseFloat(Tool_Max_Torque) ||  (parseFloat(Torque_Window_Add_A_value) - parseFloat(inputValue)) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Angle_Window_Subtraction_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var Angle_Window_Add_A_value = parseFloat(document.getElementById('Angle_Window_Add_A').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    // if (!/^\d{0,5}?$/.test(inputValue) || (parseFloat(inputValue) + Angle_Window_Add_A_value) > 30600 ||  (Angle_Window_Add_A_value - inputValue) < 0 ) {
                    if (!/^\d{0,5}?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;

                default:
                    break;
            }
        });
    });




});