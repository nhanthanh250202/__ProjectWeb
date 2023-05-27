$(document).ready(function () {
    $("#change-tab-btn").click(function (e) { 
        
        if ($("#change-tab-btn i").hasClass("ri-key-fill")) {
            $("#inforChange").css("display", "none");
            $("#change-tab-btn p").text("Thay đổi thông tin");
            $("#change-tab-btn i").removeClass("ri-key-fill");
            $("#change-tab-btn i").addClass("ri-information-line");
        }else{
            $("#inforChange").css("display", "flex");
            $("#change-tab-btn p").text("Thay đổi mật khẩu");
            $("#change-tab-btn i").removeClass("ri-information-line");
            $("#change-tab-btn i").addClass("ri-key-fill");
        }

    });
});

