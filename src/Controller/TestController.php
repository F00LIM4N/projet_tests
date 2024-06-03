<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Manager\DbService;
use Psr\Log\LoggerInterface;

class TestController extends AbstractController
{

    private $dbService;

    public function __construct(DbService $dbService, LoggerInterface $logger)
    {
        $this->dbService = $dbService;
        $this->logger = $logger;
    }


    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $this>logger->info('-------------------------------');
        $players = $this->dbService->getPlayers();
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'players' => $players,
        ]);
    }
}
