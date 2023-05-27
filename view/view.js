var baseUrl = "../audio/view/";
var audio = ["click.mp3", "win.mp3", "close.mp3","result.mp3"];
window.onclick = function(e) {
    new Audio(baseUrl + audio[0]).play();
}


const getRandomIntInclusive = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
};


function makeRandom(amountRandomNumber) {
    number=[];
      for (let i = 1; number.length < amountRandomNumber; i += 1) {
        random_number = getRandomIntInclusive(1, amountRandomNumber);
        if(number.includes(random_number)== false){
            number.push(random_number);
        }
        
      }
    return number;

}
/***********TEAM CREATOR ********/
teams=[];
score=[];
number_teams=0;
quest_clicked=0;
selector_quest = [];
turn = 0;

function createNumTeams() {
    $("#team-input").css("border-bottom", "none");
    if ($("#team-input").val()== null || $("#team-input").val() <2) {
        $("#errorNum").css("display", "block");

    }else{
        $("#errorNum").css("display", "none");
        $('#teams').html('');
        $('.second-block p').css("display", "none")
        number_teams = $("#team-input").val();
        for (let i = 0; i < number_teams; i++) {
            var teams_name = '<input id="team-'+(i+1)+'" type="text" placeholder="Đội '+(i+1)+'"></input><p id="error-team-'+(i+1)+'" class="error">Vui lòng không để trống</p> <br>';
            $('#teams').append(teams_name).trigger('create'); 
        }
    }
};

function createNameTeams(){
    for (let i = 0; i < number_teams; i++) {
        //Khởi tạo tên và số điểm
        teams.push($("#team-"+(i+1)).val());
        score.push(0);
    }
} 


/*********RANGE SLIDER**************/

$(function() {
    $("#num-grid").on('input', function(e){
        $("#output-slider").text($(this).val());
    })
});

function validateInput() {


    if ($("#team-input").val()== null || $("#team-input").val() <2) {
        $("#errorNum").css("display", "block");
        return false;
    }else{
        if (number_teams ==0)
        {
            $("#errorNum").css("display", "block");
            $("#errorNum").text("Chọn vào đặt tên để tiến hành đặt tên")
            return false;
        }
    }

    $("#errorNum").css("display", "none");
    for (let i = 0; i < number_teams; i++) {
        if ($("#team-"+(i+1)).val()== null || $("#team-"+(i+1)).val() == "") {
            $("#error-team-"+(i+1)).css("display", "block");
            return false;
        }else
        {
            $("#error-team-"+(i+1)).css("display", "none");
        }
    }
    if ($("#num-grid").val() <2) {
        $("#errorRange").css("display", "block");
        return false;
    }
    return true;
}

function createGame() {
    if (validateInput()) {
        createNameTeams();
        $(".start").css("display", "none");
        $("#setting-block").css("display","none");
        $(".second-section").css("display","flex");
        
        $('#grid-btn').html('');
        number_btn = $("#num-grid").val();
        selector_quest= makeRandom(number_btn);
        number_col = Math.round(Math.sqrt(number_btn));
        var class_for_btn;
        for (let i = 1; i <= number_btn; i++) {
            if(i%2==0)
            {
                class_for_btn = "btn-even";
            }
            else{
                class_for_btn = "btn-odd";
            }
           var btn =  '<button id="quest-btn" onclick="vistQuest()" class="'+class_for_btn+'" >' +(i)+'</button> ';
           $('#grid-btn').append(btn).trigger('create'); 
    
           if (i%number_col == 0) {
                var break_row = '<br>';
                $('#grid-btn').append(break_row).trigger('create'); 
           }
    
        }
        displayTeam();
        $("#team-1 #name").addClass("team-active");
    }
};



function vistQuest() {
    window.question_clicked= question_clicked+1;
    $(event.target).css({"opacity": "0", "cursor":"default"});
    $(event.target).prop('disabled', true);
    var question_clicked = selector_quest[$(event.target).text()-1];
    $("#quest-display").css("display", "flex");
    $.post("viewdb.php", {number_quest: question_clicked},
        function (data) {
            $("#quest-display").html(data);
        },
    );
}

function displayTeam(){
    $('#score-display').html('');
    for (let i = 0; i < teams.length; i++) {
        var section_team = '<div  id="team-'+(i+1)+'"><label>Đội</label><h1 id="name">'+(teams[i])+'</h1><h2 id="score">'+score[i]+'</h2></div>';
        $('#score-display').append(section_team).trigger('create');
    }
}

//ANIMATION SCORE
function scoreDisplay(display,oldScore,newScore) {
    $(display).text(oldScore);      
    if(oldScore < newScore){
        setTimeout(()=>scoreDisplay(display,oldScore+1,newScore),10);
    }
}

function scoreRecord(bool){
    var this_score = parseInt($("#current-score").text());
    var this_team_score = "#team-" + (turn+1) + " #score";
    if(bool == true){
        new Audio(baseUrl + audio[1]).play();
        score[turn] += this_score;
        scoreDisplay(this_team_score,score[turn] - this_score,score[turn]);
    }else{
        new Audio(baseUrl + audio[2]).play();
        score[turn] += 0;
    }
    // $(this_team_score).text(score[turn]);

    var this_team = "#team-" + (turn+1) + " #name"; 
    $(this_team).removeClass("team-active");
    quest_clicked+=1;
    turn +=1;
    if (turn == teams.length){turn=0;}    
    var next_team = "#team-" + (turn+1) + " #name";
    $(next_team).addClass("team-active");

    $("#quest-display").css("display", "none");
    if (quest_clicked == $("#num-grid").val() ) {
        var bgm = document.getElementById("bgm");
        bgm.volume=0;
        new Audio(baseUrl + audio[3]).play();
        FinalDisplay();
    }
}
function FinalDisplay() {
    $("#grid-btn").css("display", "none");
    $("#score-display").css("display", "none");
    var higest_score = Math.max.apply(Math, score);
    var winner_team=[];
    console.log(higest_score);
    for (let i = 0; i < score.length; i++) {
        if (score[i]==higest_score) {
            winner_team.push(teams[i]);
        }
    }
    $("#corgi2").attr("src", "../image/view/corgi5.gif");
    console.log (winner_team);
    for (let i = 0; i < winner_team.length; i++) {
        var winner_team_txt = '<h2>'+winner_team[i]+'</h2>';
        $('.backSide').append(winner_team_txt).trigger('create');
    }
    $("#winner").css("display", "flex");

}


function showResult() {
    $("#heading-quest").text("Đáp án câu hỏi");
    $("#question-sec").css("display", "none");
    $(".result").css("display", "block");
}

$(document).ready(function () {
    var bgm = document.getElementById("bgm");
    $("button#volume-icon").click(function () { 
        if ($("button#volume-icon").hasClass("ri-volume-up-line")) {
            $("button#volume-icon").removeClass("ri-volume-up-line");
        
            $("button#volume-icon").addClass("ri-volume-mute-line");
            bgm.volume=0;
            $("#volume-range").val(0);
        }else{
            $("button#volume-icon").addClass("ri-volume-up-line");
            $("button#volume-icon").removeClass("ri-volume-mute-line");
            bgm.volume=1;
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
        bgm.volume = volume_val;

    });




});