<?php

namespace App\Manager;

class DbService
{
    private $pdo;

    public function __construct($dbPath = '/ressources/data.db')
    {
        $this->pdo = new \PDO('sqlite:///%kernel.project_dir%/resources/data.db');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getPlayers()
    {
        $stmt = $this->pdo->query('SELECT * FROM Player');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMatches()
    {
        $stmt = $this->pdo->query('SELECT * FROM Match');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPlayerById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Player WHERE ID = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getMatchesByPlayerId($playerId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Match WHERE ID_Player1 = :playerId OR ID_Player2 = :playerId');
        $stmt->bindParam(':playerId', $playerId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addPlayer($name){
        $stmt = $this->pdo->prepare('INSERT INTO PLAYER (Name) VALUES (:name)');
        $stmt->bindParam(':name',$name,\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addMatch($idPlayer1, $idPlayer2, $winIdPlayer)
    {
        $stmt = $this->pdo->prepare('INSERT INTO Match (ID_Player1, ID_Player2, Win_ID_Player) VALUES (:idPlayer1, :idPlayer2, :winIdPlayer)');
        $stmt->bindParam(':idPlayer1', $idPlayer1, \PDO::PARAM_INT);
        $stmt->bindParam(':idPlayer2', $idPlayer2, \PDO::PARAM_INT);
        $stmt->bindParam(':winIdPlayer', $winIdPlayer, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}