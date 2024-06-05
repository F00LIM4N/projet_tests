<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\DbService;

class PlayerController extends AbstractController
{
    public function __construct(
        private DbService $dbService,
        private RequestStack $requestStack,
    ) { }

    #[Route('/player', name: 'app_player')]
    public function index(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        $gameName = $request->get('gameName');
        $session->set('player', $gameName);

        $this->dbService->addPlayer($gameName);

        $leaderboard = $this->dbService->getLeaderboard();

        $opponentKey = array_rand($leaderboard);
        if ($leaderboard[$opponentKey]['name'] !== $gameName) {
            $opponent = $leaderboard[$opponentKey]['name'];
            $session->set('opponent', $opponent);
        } else {
            throw new Exception('No players found');
        }

        return $this->render('player/index.html.twig', [
            'prenom' => $gameName,
            'players' => $leaderboard,
            'opponent' => $opponent,
        ]);
    }
}
