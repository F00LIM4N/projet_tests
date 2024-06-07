<?php

namespace App\Tests;

use App\Manager\DbService;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Exception;

final class TestUnitaireTest extends TestCase
{
    private DbService $dbService;
    private Connection $connection;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->dbService = new DbService($this->connection);
    }

    /**
     * @throws Exception
     */
    public function testGetPlayers()
    {
        $players = $this->dbService->getPlayers();

        $this->assertIsArray($players);
    }

    public function testGetMatches() {
        $dbService = new DbService($this->connection);

        $matches = $dbService->getMatches();

        $this->assertIsArray($matches);
    }

    public function testGetPlayerById() {
        $dbService = new DbService($this->connection);
        $id = 1;

        $player = $dbService->getPlayerById($id);

        $this->assertIsArray($player);
    }

    public function testGetMatchesByPlayerId() {
        $dbService = new DbService($this->connection);
        $playerId = 1;

        $matches = $dbService->getMatchesByPlayerId($playerId);

        $this->assertIsArray($matches);
    }

    public function testAddPlayer()
    {
        $name = 'test';

        $this->connection
            ->expects($this->once())
            ->method('fetchAllAssociative')
            ->with(
                $this->stringContains('SELECT COUNT(*) AS \'EXIST\' FROM PLAYER WHERE Name = :name'),
                $this->arrayHasKey('name')
            )
            ->willReturn([['EXIST' => 0]]);

        $this->connection
            ->expects($this->once())
            ->method('executeStatement')
            ->with(
                $this->stringContains('INSERT INTO PLAYER (Name) VALUES (:name)'),
                $this->arrayHasKey('name')
            )
            ->willReturn(1);

        $player = $this->dbService->addPlayer($name);

        $this->assertIsInt($player);
    }

    public function testAddMatch()
    {
        $idPlayer1 = 1;
        $idPlayer2 = 2;
        $winIdPlayer = 1;
        $expectedResult = 1;

        $this->connection
            ->expects($this->once())
            ->method('executeStatement')
            ->with(
                $this->stringContains('INSERT INTO Match'),
                $this->arrayHasKey('idPlayer1')
            )
            ->willReturn($expectedResult);

        $match = $this->dbService->addMatch($idPlayer1, $idPlayer2, $winIdPlayer);

        $this->assertIsInt($match);
        $this->assertEquals($expectedResult, $match);
    }
}