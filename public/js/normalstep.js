//驗證輸入

$(document).ready(function() {
    // 获取输入元素
    var targetTorqueInput = document.getElementById("Target_Torque");
    var runDownSpeedInput = document.getElementById("Run_Down_Speed");
    var downshiftTorqueInput = document.getElementById("Downshift_Torque");
    var downshiftSpeedInput = document.getElementById("Downshift_Speed");
    var highAngleInput = document.getElementById("High_Angle");
    var lowAngleInput = document.getElementById("Low_Angle");
    var preRunRpmInput = document.getElementById("Pre_Run_RPM");
    var preRunAngleInput = document.getElementById("Pre_Run_Angle");
    var hiTorqueInput = document.getElementById("Hi_Torque");
    var lowTorqueInput = document.getElementById("Low_Torque");
    var thresholdTorqueInput = document.getElementById("Threshold_Torque");
    var jointOffSetInput = document.getElementById("Joint_OffSet");

    // 添加输入事件监听器
    // targetTorqueInput.addEventListener("input", function() {
    //     var value = targetTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value)) {
    //         targetTorqueInput.classList.add("is-invalid");
    //     } else {
    //         targetTorqueInput.classList.remove("is-invalid");
    //     }
    // });

    // runDownSpeedInput.addEventListener("input", function() {
    //     var value = runDownSpeedInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value < 20 || value > 1100) {
    //         runDownSpeedInput.classList.add("is-invalid");
    //     } else {
    //         runDownSpeedInput.classList.remove("is-invalid");
    //     }
    // });

    // downshiftTorqueInput.addEventListener("input", function() {
    //     var value = downshiftTorqueInput.value.trim();
    //     var targetTorqueValue = targetTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value > targetTorqueValue) {
    //         downshiftTorqueInput.classList.add("is-invalid");
    //     } else {
    //         downshiftTorqueInput.classList.remove("is-invalid");
    //     }
    // });

    // downshiftSpeedInput.addEventListener("input", function() {
    //     var value = downshiftSpeedInput.value.trim();
    //     var runDownSpeedValue = runDownSpeedInput.value.trim();
    //     console.log(runDownSpeedValue)
    //     console.log(value)
    //     if (!/^\d{0,4}$/.test(value) || parseFloat(value) > runDownSpeedValue || parseFloat(value) < 20) {
    //         downshiftSpeedInput.classList.add("is-invalid");
    //         console.log(1)
    //     } else {
    //         downshiftSpeedInput.classList.remove("is-invalid");
    //         console.log(0)
    //     }
    // });

    // highAngleInput.addEventListener("input", function() {
    //     var value = highAngleInput.value.trim();
    //     if (!/^\d+$/.test(value) || value < 0 || value > 30600) {
    //         highAngleInput.classList.add("is-invalid");
    //     } else {
    //         highAngleInput.classList.remove("is-invalid");
    //     }
    // });

    // lowAngleInput.addEventListener("input", function() {
    //     var value = lowAngleInput.value.trim();
    //     if (!/^\d+$/.test(value) || value < 0 || value > 305999) {
    //         lowAngleInput.classList.add("is-invalid");
    //     } else {
    //         lowAngleInput.classList.remove("is-invalid");
    //     }
    // });

    // preRunRpmInput.addEventListener("input", function() {
    //     var value = preRunRpmInput.value.trim();
    //     if (!/^\d{1,4}$/.test(value) || value < 20 || value > 1100) {
    //         preRunRpmInput.classList.add("is-invalid");
    //     } else {
    //         preRunRpmInput.classList.remove("is-invalid");
    //     }
    // });

    // preRunAngleInput.addEventListener("input", function() {
    //     var value = preRunAngleInput.value.trim();
    //     if (!/^\d+$/.test(value) || value < 1 || value > 30600) {
    //         preRunAngleInput.classList.add("is-invalid");
    //     } else {
    //         preRunAngleInput.classList.remove("is-invalid");
    //     }
    // });

    // hiTorqueInput.addEventListener("input", function() {
    //     var value = hiTorqueInput.value.trim();
    //     var targetTorqueValue = targetTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value <= targetTorqueValue) {
    //         hiTorqueInput.classList.add("is-invalid");
    //     } else {
    //         hiTorqueInput.classList.remove("is-invalid");
    //     }
    // });

    // lowTorqueInput.addEventListener("input", function() {
    //     var value = lowTorqueInput.value.trim();
    //     var targetTorqueValue = targetTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value >= targetTorqueValue) {
    //         lowTorqueInput.classList.add("is-invalid");
    //     } else {
    //         lowTorqueInput.classList.remove("is-invalid");
    //     }
    // });

    // thresholdTorqueInput.addEventListener("input", function() {
    //     var value = thresholdTorqueInput.value.trim();
    //     var targetTorqueValue = targetTorqueInput.value.trim();
    //     var downshiftTorqueValue = downshiftTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value <= downshiftTorqueValue || value >= targetTorqueValue) {
    //         thresholdTorqueInput.classList.add("is-invalid");
    //     } else {
    //         thresholdTorqueInput.classList.remove("is-invalid");
    //     }
    // });

    // jointOffSetInput.addEventListener("input", function() {
    //     var value = jointOffSetInput.value.trim();
    //     var targetTorqueValue = targetTorqueInput.value.trim();
    //     if (!/^(\d{1,4}(\.\d{0,2})?)?$/.test(value) || value >= targetTorqueValue) {
    //         jointOffSetInput.classList.add("is-invalid");
    //     } else {
    //         jointOffSetInput.classList.remove("is-invalid");
    //     }
    // });


    // 选中所有输入框
    var inputs = document.querySelectorAll('input');
    let Tool_Max_Torque = parseFloat(document.getElementById('Tool_Max_Torque').value);
    let Tool_Max_RPM = parseFloat(document.getElementById('tool_maxrpm').value);

    // 遍历输入框并添加即时验证和值替换
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var inputValue = input.value.trim();

            // 根据输入框的 id 执行相应的验证逻辑和值替换
            switch (input.id) {
                case 'Target_Torque':
                    // 限制輸入4位數和小數點後兩位
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                        // input.classList.add("is-invalid");
                    }else{
                    	// input.classList.remove("is-invalid");
                    }
                    break;
                case 'Run_Down_Speed':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Run_Down_Speed_A':
                    // 限制輸入4位數和範圍20~Tool_Max_RPM
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Downshift_Torque':
                    // 不可大於Target_Torque，限制輸入4位數和小數點後兩位
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Downshift_Speed':
                    // 不可大於Run_Down_Speed，大於20
                    var runDownSpeed = parseFloat(document.getElementById('Run_Down_Speed').value);
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'High_Angle':
                    // 限制1~30600
                    if (!/^\d{1,5}$/.test(inputValue) || inputValue < 1 || inputValue > 30600) {
                        input.value = '';
                    }
                    break;
                case 'Low_Angle':
                    // 限制0~305999
                    if (!/^\d{1,6}$/.test(inputValue) || inputValue < 0 || inputValue > 305999) {
                        input.value = '';
                    }
                    break;
                case 'Pre_Run_RPM':
                    // 限制20~Tool_Max_RPM，最大四位數，没有小数点
                    if (!/^\d{1,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Pre_Run_Angle':
                    // 限制1~30600
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Torque':
                    // 限制輸入4位數和小數點後兩位，大於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) < targetTorque || parseFloat(inputValue) > parseFloat(Tool_Max_Torque) ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';  //
                    }
                    break;
                case 'Low_Torque':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Threshold_Torque':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque且大於Downshift_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    var downshiftTorque = parseFloat(document.getElementById('Downshift_Torque').value);
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Joint_OffSet':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Target_Angle_A':
                    // 限制1~30600
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Angle_A':
                    // let Target_Angle_A_Value = parseFloat(document.getElementById('Target_Angle_A').value);
                    // 限制1~30600
                    if (!/^\d{1,5}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Low_Angle_A':
                    let High_Angle_A_Value = parseFloat(document.getElementById('Hi_Angle_A').value);
                    // 限制0~305999
                    if (!/^\d{1,5}$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Hi_Torque_A':
                    // 限制輸入4位數和小數點後兩位，大於Target_Torque
                    var targetTorque = Tool_Max_Torque;
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue)  ) {
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';  //
                    }
                    break;
                case 'Low_Torque_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque
                    var targetTorque = parseFloat(document.getElementById('Target_Torque').value);
                    // if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) || parseFloat(inputValue) >= targetTorque || parseFloat(inputValue) < 0 ) {
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Threshold_Torque_A':
                    // 限制輸入4位數和小數點後兩位，小於Target_Torque且大於Downshift_Torque
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Downshift_Torque_A':
                    // 不可大於Target_Torque，限制輸入4位數和小數點後兩位
                    var Threshold_Torque_A_Value = parseFloat(document.getElementById('Downshift_Torque_A').value);
                    if (!/^\d{0,6}(\.\d{0,4})?$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Downshift_Speed_A':
                    // 不可大於Target_Torque，限制輸入4位數和小數點後兩位
                    var Threshold_Torque_A_Value = parseFloat(document.getElementById('Downshift_Speed_A').value);
                    if (!/^\d{0,4}$/.test(inputValue) ) {
                        input.value = '';
                    }
                    break;
                case 'Pre_Run_RPM_A':
                    let Pre_Run_RPM_A = parseFloat(document.getElementById('Pre_Run_RPM_A').value);
                    // 限制0~305999
                    if (!/^\d{1,4}$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;
                case 'Pre_Run_Angle_A':
                    let Pre_Run_Angle_A = parseFloat(document.getElementById('Pre_Run_Angle_A').value);
                    // 限制0~305999
                    if (!/^\d{1,5}$/.test(inputValue)  ) {
                        input.value = '';
                    }
                    break;


                default:
                    break;
            }
        });
    });






});