<?php
class DataFunctions
{
    /*OPPONENTS*/
    public function getSetOpponent($opponentName, $opposingTeam)
    {
        $getOpponent = $this->getOpponent($opponentName);
        //$this->printNeat($getOpponent, "Initial Opponent Result in getSetOpponent: ");
        if (count($getOpponent) <= 0) {
            //Opponent does not exist, add opponent
            $opponentArgs = array(
                'playerName' => $opponentName,
                'teamName' => $opposingTeam['teamName'],
                'teamID' => "{$opposingTeam['id']}"
            );
            //$this->printNeat($opponentArgs, "Adding Opponent: ");
            $this->addOpponent($opponentArgs);
        }
        $opponent = $this->getOpponent($opponentName);
        return $opponent;
    }
    private function addOpponent($opponentArgs)
    {
        $jsonFile = 'json/opponents.json';
        $id = $this->getNewEntryID($jsonFile);
        $opponentArgs['id'] = "$id";
        $this->updateJSONfile($jsonFile, $opponentArgs);
    }
    public function getOpponent($opponentName)
    {
        $opponents = $this->getJSONData('json/opponents.json');
        $opponentInfo = array();
        foreach ($opponents as $opponent) {
            if ($opponent['playerName'] == $opponentName) {
                $opponentInfo = $opponent;
            }
        }
        return $opponentInfo;
    }

    /*OPPOSING TEAMS*/
    public function getSetOpposingTeam($teamName)
    {
        $getTeam = $this->getOpposingTeam($teamName);
        //$this->printNeat($getTeam, "Initial Team Result in getSetOpposingTeam: ");
        if (count($getTeam) <= 0) {
            //$this->printNeat($teamName, "Adding Team: ");
            $this->addOpposingTeam($teamName);
        }
        $team = $this->getOpposingTeam($teamName);
        return $team;
    }
    public function getOpposingTeam($teamName)
    {
        $opposingTeams = $this->getJSONData('json/opposingTeams.json');
        $teamInfo = array();
        foreach ($opposingTeams as $team) {
            if ($team['teamName'] == $teamName) {
                $teamInfo = $team;
            }
        }
        return $teamInfo;
    }
    private function addOpposingTeam($teamName)
    {
        $jsonFile = 'json/opposingTeams.json';
        $entryID = $this->getNewEntryID($jsonFile);
        $teamArgs = array(
            'id' => "$entryID",
            'teamName' => $teamName
        );
        $this->updateJSONfile($jsonFile, $teamArgs);
    }

    //Matches
    public function addMatches($jsonFile, $data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFile, $jsonData)) {
            echo "Matches successfully written to $jsonFile </br>";
        } else {
            echo "Error writing data to $jsonFile </br>";
        }
    }

    //Modify JSON Data
    private function getJSONData($jsonFile)
    {
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        return $data;
    }
    private function updateJSONfile($jsonFile, $data)
    {
        $existingData = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : array();
        $existingData[] = $data;
        $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFile, $jsonData)) {
            echo "Data successfully written to $jsonFile </br>";
        } else {
            echo "Error writing data to $jsonFile </br>";
        }
    }
    private function getNewEntryID($jsonFile)
    {
        $data = $this->getJSONData($jsonFile);
        $lastEntry = end($data);
        $newEntryID = $lastEntry['id'] + 1;
        return $newEntryID;
    }

    //Custom Functions
    public function printNeat($data, $msg = "")
    {
        if (is_array($data) || is_object($data)) {
            echo "<pre>";
            echo "<h3>$msg</h3>";
            print_r($data);
            echo "</pre>";
        } else {
            echo "<p>$msg $data</p>";
        }
    }    
}
$functions = new DataFunctions();