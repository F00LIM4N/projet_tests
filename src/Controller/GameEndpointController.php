<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\DbService;

class GameEndpointController extends AbstractController
{
    public function __construct(
        private DbService $dbService,
        private RequestStack $requestStack,
    ) { }

    #[Route('/game-endpoint', name: 'app_game_endpoint')]
    public function index(Request $request)
    {
        $session = $request->getSession();

        $player = $session->get('player');
        $opponent = $session->get('opponent');

        $data = json_decode($request->getContent(), true);

        if ($data['winner'] === 'X') {
            $data['winner'] = $player;
        } else {
            $data['winner'] = $opponent;
        }

        $templates = $this->dbService->playerWin($data['winner']);

        return new JsonResponse($templates);
    }
}
