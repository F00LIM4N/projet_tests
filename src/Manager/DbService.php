<?php

namespace App\Manager;

use Doctrine\DBAL\Connection;

class DbService
{
    public function __construct(
        private Connection $db,
    ) { }

    public function getPlayers()
    {
        return $this->db->fetchAllAssociative('SELECT * FROM Player');
    }

    public function getMatches()
    {
        return $this->db->fetchAllAssociative('SELECT * FROM Match');
    }

    public function getPlayerById($id)
    {
        $sql = 'SELECT * FROM Player WHERE ID = :id';
        return $this->db->fetchAllAssociative($sql, [
            'id' => $id
        ]);
    }

    public function getMatchesByPlayerId($playerId)
    {
        $sql = 'SELECT * FROM Match WHERE ID_Player1 = :playerId OR ID_Player2 = :playerId';
        return $this->db->fetchAllAssociative($sql, [
            'playerId' => $playerId
        ]);
    }

    public function addPlayer($name)
    {
        $existingPlayer = $this->db->fetchAllAssociative("
            SELECT COUNT(*) AS 'EXIST' FROM PLAYER WHERE Name = :name
        ", [
            'name' => $name
        ]);
        if ($existingPlayer[0]['EXIST'] > 0) {
            return;
        }
        return $this->db->executeStatement("
            INSERT INTO PLAYER (Name) VALUES (:name)
        ", [
            'name' => $name
        ]);
    }

    public function addMatch($idPlayer1, $idPlayer2, $winIdPlayer)
    {
        return $this->db->executeStatement("
            INSERT INTO Match (ID_Player1, ID_Player2, Win_ID_Player) VALUES (:idPlayer1, :idPlayer2, :winIdPlayer)
        ", [
            'idPlayer1' => $idPlayer1,
            'idPlayer2' => $idPlayer2,
            'winIdPlayer' => $winIdPlayer
        ]);
    }

    public function getLeaderboard()
    {
        $playersResults = $this->db->fetchAllAssociative('
            SELECT
            ID_Player1 AS PlayerID,
            SUM(CASE WHEN Win_ID_Player = ID_Player1 THEN 1 ELSE 0 END) AS Wins
        FROM Match
        GROUP BY ID_Player1
        UNION ALL
        SELECT
            ID_Player2 AS PlayerID,
            SUM(CASE WHEN Win_ID_Player = ID_Player2 THEN 1 ELSE 0 END) AS Wins
        FROM Match
        GROUP BY ID_Player2');    
        
        $accumulatedWins = [];

        foreach ($playersResults as $element) {
            $playerID = $element["PlayerID"];
            $wins = $element["Wins"];

            if (isset($accumulatedWins[$playerID])) {
                $accumulatedWins[$playerID] += $wins;
            } else {
                $accumulatedWins[$playerID] = $wins;
            }
        }

        
        $leaderboard= $this->matchPlayersToTheirWins($accumulatedWins);

        $restructuredArray = [];
        foreach ($leaderboard as $playerId => $playerData) {
            $playerData['ID'] = $playerId;
            $restructuredArray[] = $playerData;
        }
        return $restructuredArray;
    }

    public function matchPlayersToTheirWins($accumulatedWins)
    {
        
        $players = $this->getPlayers();

        $idToNameMap = [];
        foreach ($players as $player) {
            $idToNameMap[$player["ID"]] = $player["Name"];
        }

        $combinedInfo = [];
        foreach ($idToNameMap as $playerId => $playerName) {
            $wins = isset($accumulatedWins[$playerId]) ? $accumulatedWins[$playerId] : 0;
            $combinedInfo[$playerId] = [
                'name' => $playerName,
                'wins' => $wins
            ];
        }

        return $combinedInfo;
    }
}

