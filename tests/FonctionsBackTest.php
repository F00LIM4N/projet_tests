<?php

namespace App\Tests;

use App\Manager\DbService;
use Doctrine\DBAL\Exception;

class FonctionsBackTest
{
    public function __construct(
        private DbService $db,
    ) { }

    /**
     * @throws Exception
     */
    public function testGetPlayers() {
        $dbService = new DbService($this->db);

        $players = $dbService->getPlayers();

        $this->assertIsArray($players);
        $this->assertNotEmpty($players);
    }

    /**
     * @throws Exception
     */
    public function testGetMatches() {
        $dbService = new DbService($this->db);

        $matches = $dbService->getMatches();

        $this->assertIsArray($matches);
        $this->assertNotEmpty($matches);
    }

    /**
     * @throws Exception
     */
    public function testGetPlayerById() {
        $dbService = new DbService($this->db);
        $id = 1;

        $player = $dbService->getPlayerById($id);

        $this->assertIsArray($player);
        $this->assertNotEmpty($player);
    }

    /**
     * @throws Exception
     */
    public function testGetMatchesByPlayerId() {
        $dbService = new DbService($this->db);
        $playerId = 1;

        $matches = $dbService->getMatchesByPlayerId($playerId);

        $this->assertIsArray($matches);
        $this->assertNotEmpty($matches);
    }

    /**
     * @throws Exception
     */
    public function testAddPlayer() {
        $dbService = new DbService($this->db);
        $name = 'test';

        $player = $dbService->addPlayer($name);

        $this->assertNull($player);
    }

    /**
     * @throws Exception
     */
    public function testAddMatch() {
        $dbService = new DbService($this->db);
        $idPlayer1 = 1;
        $idPlayer2 = 2;
        $winIdPlayer = 1;

        $match = $dbService->addMatch($idPlayer1, $idPlayer2, $winIdPlayer);

        $this->assertIsInt($match);
    }
}