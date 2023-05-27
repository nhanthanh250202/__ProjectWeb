$(document).ready(function() {
    $("#thecheckbox").change(function () { 
    $.ajax({
        type: "POST",
        url: "update-detail.php?privacychange",
        data: {privacychange: $("#thecheckbox").val()},
        success: function () {
            $("#stust").html("");
        }
        
        });
    });
});