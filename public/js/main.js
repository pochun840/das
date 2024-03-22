

function clearInvalidClass() {
    var inputs = document.querySelectorAll('input.is-invalid');

    inputs.forEach(function(input) {
        input.classList.remove('is-invalid');
    });
}

function disableAllButtonsAndInputs() {
    // 获取所有按钮元素
    var buttons = document.getElementsByTagName("button");
    
    // 获取所有输入框元素
    var inputs = document.getElementsByTagName("input");

    // 获取所有输入框元素
    var selects = document.getElementsByTagName("select");
    
    // 禁用所有按钮
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = true;
    }
    
    // 禁用所有输入框
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = true;
    }

    // 禁用所有输入框
    for (var i = 0; i < selects.length; i++) {
        selects[i].disabled = true;
    }
}
