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

    public function addPlayer($name){
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
}