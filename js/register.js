
function onlyLettersAndNumbers(str) {
    return Boolean(str.match(/^[A-Za-z0-9]*$/));
}
function checkName(){
    input_name = document.forms["registerForm"]["name"].value;
    
}

function checkUser(){
    username = document.forms["registerForm"]["username"].value;
    if(!onlyLettersAndNumbers(username)){
        $("#username-error").css("display", "inline");
        return false;
    }
    else{
        $("#username-error").css("display", "none");
        return true;
    }
}

function checkConfirm() {
    var pass = document.forms["registerForm"]["password"].value;
    var confpass = document.forms["registerForm"]["confirm_password"].value;
    if(!checkUser()){
        alert("Vui lòng kiểm tra lại tên người dùng");
        return false;
    }


    if (pass != confpass) {
        alert("Xác thực mật khẩu sai vui lòng nhập lại");
        return false;
    }else{
        return true;
    }
}

var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
    URL.revokeObjectURL(output.src) // free memory
    }
};