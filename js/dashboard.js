$(document).ready(function () {
    var vid = document.getElementById("bgvideo");
    $("button.action-btn").click(function () {
        var this_menu =$(event.target).next();
        $(this_menu).css("display", "flex");
    });
    window.onclick = function(e) {
        if (!e.target.matches('button.action-btn')){
            $(".action-menu").css("display", "none");
        }
    }
    $("button#volume-icon").click(function () { 
        if ($("button#volume-icon").hasClass("ri-volume-up-line")) {
            $("button#volume-icon").removeClass("ri-volume-up-line");
        
            $("button#volume-icon").addClass("ri-volume-mute-line");
            vid.volume=0;
            $("#volume-range").val(0);
        }else{
            $("button#volume-icon").addClass("ri-volume-up-line");
            $("button#volume-icon").removeClass("ri-volume-mute-line");

            vid.volume=1;
            $("#volume-range").val(1);
        }
    });
    $("#volume-range").change(function (e) { 
        volume_val = $("#volume-range").val();
        if (volume_val ==0) {
            $("button#volume-icon").removeClass("ri-volume-up-line");
            $("button#volume-icon").addClass("ri-volume-mute-line");
        }else{
            $("button#volume-icon").addClass("ri-volume-up-line");
            $("button#volume-icon").removeClass("ri-volume-mute-line");
        }
        vid.volume = volume_val;

    });

});


function setupTabs() {
    document.querySelectorAll(".tab-button").forEach(button =>{
        button.addEventListener("click", ()=>{
            const sideBar = button.parentElement;
            const tabContainer = sideBar.parentElement;
            const tabNumber = button.dataset.forTab;
            const tabToActive = tabContainer.querySelector(`.render-table[data-tab="${tabNumber}"]`);
            sideBar.querySelectorAll(".tab-button").forEach(button=> {
                button.classList.remove("tab-button-active");

            });
            tabContainer.querySelectorAll(".render-table").forEach(button=> {
                button.classList.remove("render-table-active");

            });
            button.classList.add("tab-button-active");
            tabToActive.classList.add("render-table-active");
        });
    });
}

document.addEventListener("DOMContentLoaded", ()=>{
    setupTabs();
})