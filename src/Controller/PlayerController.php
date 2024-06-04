<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\DbService;

class PlayerController extends AbstractController
{
    public function __construct(
        private DbService $dbService,
    ) { }

    #[Route('/player', name: 'app_player')]
    public function index(Request $request): Response
    {
        $this->dbService->addPlayer($request->get('gameName'));

        return $this->render('player/index.html.twig', [
            'prenom' => $request->get('gameName'),
            'players' => $this->dbService->getPlayers(),
        ]);
    }
}
