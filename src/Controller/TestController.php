<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Manager\DbService;

class TestController extends AbstractController
{
    public function __construct(
        private DbService $dbService,
    ) { }

    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $players = $this->dbService->getPlayers();
        return $this->render('test/index.html.twig', [
            'players' => $players,
        ]);
    }
}