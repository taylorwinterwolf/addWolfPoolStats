<?php
if(isset($_POST['submitStats'])) {
    require_once('dataAPI.php');
    require_once('players.php');

    $postData = $_POST;
    $functions->printNeat($postData, "Post Data in submitStats.php: <br>");
    $opposingTeam = $functions->getSetOpposingTeam($postData['opposingTeamName']);
    $currentDate = date('Y-m-d');
    $format = $postData['formatInput'];

    $matchesArray = array();
    foreach ($postData['matches'] as $matchNumber => $match) {
        $playerID = $match['playerID'];
        $playerName = $players[$playerID]['name'];
        $playerSkillLevel = $match['skillLevel'];
        $playerMatchPoints = $match['matchPoints'];
        $playerPointsMade = $match['pointsMade'];
        $playerRacksWon = $match['racksWon'];
        $playerMatchPoints = $match['matchPoints'];
        
        $opponent = $functions->getSetOpponent($match['opponentName'], $opposingTeam);
        $opponentSkillLevel = $match['opponentSkillLevel'];
        $opponentMatchPoints = $match['opponentMatchPoints'];
        
        if($playerMatchPoints == $opponentMatchPoints){
            $matchResult = 2; //a tie
        }elseif($playerMatchPoints > $opponentMatchPoints){
            $matchResult = 1;
        }else{
            $matchResult = 0;
        }

        $matchArray = array(
            "playerID" => $playerID,
            "playerName" => $playerName,
            "skillLevel" => $playerSkillLevel,
            "matchResult" => "$matchResult",
            "matchPoints" => $playerMatchPoints,
            "matchNumber" => "$matchNumber",
            "opponentID" => $opponent['id'],
            "opponentName" => $opponent['playerName'],
            "opponentSkillLevel" => $opponentSkillLevel,
            "opponentMatchPoints" => $opponentMatchPoints,
            "opposingTeamID" => $opposingTeam['id'],
            "sessionID" => $postData['sessionID'],
            "datePlayed" => $postData['datePlayed'],
            "dateAdded" => $currentDate
        );
        if($format == 8){
            $matchArray['racksWon'] = $playerRacksWon;
        }else if($format == 9){
            $matchArray['pointsMade'] = $playerPointsMade;
        }

        $matchesArray[] = $matchArray;
    }
    $functions->printNeat($matchesArray, "Matches Array in submitStats.php: <br>");
    if($format == 8){
        $functions->addMatches('json/eightBallMatches.json', $matchesArray);
    }else if($format == 9){
        $functions->addMatches('json/nineBallMatches.json', $matchesArray);
    }

    //ADD TEAM MATCH STATS
    $teamMatchPoints = $postData['teamMatchPoints'];
    $opposingTeamMatchPoints = $postData['opposingTeamMatchPoints'];
    if($teamMatchPoints == $opposingTeamMatchPoints){
        //its a tie
        $teamMatchResult = 2; 
    }elseif($teamMatchPoints > $opposingTeamMatchPoints){
        $teamMatchResult = 1;
    }else{
        $teamMatchResult = 0;
    }
    
    $teamMatch = array([
        "matchResult"=>"$teamMatchResult",	
        "teamMatchPoints"=>$teamMatchPoints,	
        "opposingTeamName"=>$opposingTeam['teamName'],
        "opposingTeamID"=>$opposingTeam['id'],	
        "opposingTeamMatchPoints"=>$opposingTeamMatchPoints,				
        "sessionID"=>$postData['sessionID'],	
        "datePlayed"=>$postData['datePlayed'],	
        "dateAdded"=>$currentDate  	
    ]);
    $functions->printNeat($teamMatch, "Team Match Array in submitStats.php: <br>"); 
    if($format == 8){
        $functions->addMatches('json/eightballteammatches.json', $teamMatch);
    }else if($format == 9){
        $functions->addMatches('json/nineballteammatches.json', $teamMatch);
    }    
}
?>
</br>
<a href="/index.php">Back to Input Stats</a>
