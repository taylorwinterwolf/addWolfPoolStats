<?php
require_once('players.php');

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Matches</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<style type="text/css">
.label{
    margin:5px;
    min-width: 210px;
}
.input{
    max-width:50px;
    margin:5px;
}
.dateSelect{
    margin: 5px;
}
.opponentName{
    min-width:200px;
    margin:5px;
}
.player-wrapper{
    width:100%;
    overflow:hidden;
    padding:10px 5px;
}
.player-input-wrap{
    float:left;
}
.oddNumber{
    background-color:#c9c9c9;
}
.evenNumber{
    background-color:#323232;
    color:#fff;
}
.submit8Btn{
    margin: 10px 0px;
    padding: 10px;
    background: black;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
}
#theForm{
    display: none;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <form>
            <select name="format" id="selectFormat">
                <option value="">Select Format</option>
                <option value=8>Eight Ball</option>
                <option value=9>Nine Ball</option>
            </select>
        </form>
        <form id="theForm" name="theForm" method="post" action="submitStats.php">
            <h3>Add <span id="formatTitle"></span>-Ball Matches</h3>
            <label class="label">Opposing Team Name</label><input class="opponentName" name="opposingTeamName" required></input></br>
            <label class="label">Date Played</label><input class="dateSelect" type="date" id="play_date" name="datePlayed"></input></br>
            <label class="label">Wolf Pack Match Points</label><input class="input" name="teamMatchPoints"></input></br>
            <label class="label">Opposing Team Match Points</label><input class="input" name="opposingTeamMatchPoints"></input></br>
            <input type="hidden" name="sessionID" value="2">
            <input type="hidden" name="formatInput" value="">
            <?php /*START OF WHILE LOOP*/
                $i = 1;
                while ($i <= 5) {
                if($i % 2 == 0) {
                    $numberClass = "evenNumber";
                } else {
                    $numberClass = "oddNumber";
                }
                
                ?>
                <div class="player-wrapper <?php print($numberClass)?> row">
                    <div class="player-input-wrap col-12">
                        <div class="row">
                            <div class="col-5">
                                <select name="matches[<?php print($i) ?>][playerID]" required>
                                <option value="">Select Player</option>
                                <?php foreach ($players as $playerID => $player) { ?>
                                <option value="<?php print($playerID)?>"><?php print($player['name'])?></option>        
                                <?php } ?>
                                </select>
                                </br>
                                <label class="label">Skill Level</label><input class="input" name="matches[<?php print($i) ?>][skillLevel]" required></input></br>
                                <label class="label">Match Points</label><input class="input" name="matches[<?php print($i) ?>][matchPoints]" required></input></br>
                                <span style="display:none;" class="eightRacks"><label class="label">Racks Won</label><input class="input" name="matches[<?php print($i) ?>][racksWon]"></input></br></span>
                                <span style="display:none;" class="ninePoints"><label class="label">Points Made</label><input class="input" name="matches[<?php print($i) ?>][pointsMade]"></input></br></span>
                            </div>
                            <div class="col-5">
                                <label class="label">Opponent Name</label><input class="opponentName" name="matches[<?php print($i) ?>][opponentName]" required></input></br>
                                <label class="label">Skill Level</label><input class="input" name="matches[<?php print($i) ?>][opponentSkillLevel]" required></input></br>
                                <label class="label">Match Points</label><input class="input" name="matches[<?php print($i) ?>][opponentMatchPoints]" required></input></br>
                            </div>
                        </div>
                    </div>   
                </div>
            <?php /*END OF WHILE LOOP*/ $i++; } ?>
            <input type="submit" name="submitStats" class="submit8Btn" value="Submit Matches"/>
        </form>
        
    </div>
</div>
<script type="text/javascript">
document.getElementById("selectFormat").addEventListener("change", function() {
    var selectedOption = this.value;
    document.getElementById("theForm").style.display = "block";
    document.getElementById("formatTitle").innerHTML = selectedOption;
    document.querySelector("input[name='formatInput']").value = selectedOption;
    console.log("Selected Option: " + selectedOption);

    var ninePoints = document.querySelectorAll(".ninePoints");
    var eightRacks = document.querySelectorAll(".eightRacks");
    var oddNumberElements = document.querySelectorAll(".oddNumber");

    if(selectedOption == 9){
      console.log("9 Ball Selected");
      ninePoints.forEach(function(element) {
        element.style.display = "block";
      });
      eightRacks.forEach(function(element) {
        element.style.display = "none";
      });
      oddNumberElements.forEach(function(element) {
        element.style.backgroundColor = "#e3ce50";
      });
    } else if(selectedOption == 8){
      console.log("8 Ball Selected");
      ninePoints.forEach(function(element) {
        element.style.display = "none";
      });
      eightRacks.forEach(function(element) {
        element.style.display = "block";
      });
      oddNumberElements.forEach(function(element) {
        element.style.backgroundColor = "#c9c9c9";
      });
    }
}); 
</script>
</body>