<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestsIntegrationTest extends WebTestCase
{
    public function testDatabaseConnection()
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $connection = $entityManager->getConnection();

        try {
            $connection->executeQuery('SELECT * FROM Player');
            $isConnected = true;
        } catch (\Exception $e) {
            $isConnected = false;
        }

        $this->assertTrue($isConnected, 'La connexion à la base de données n\'a pas pu être établie.');
    }

    public function testIntegration()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('title', 'Accueil morpion');

        $this->assertSelectorTextContains('h1.text-center', 'Bienvenue au Jeu du Morpion');
        $this->assertSelectorTextContains('p.text-center', 'Le jeu du morpion (ou tic-tac-toe) est un jeu simple mais amusant pour deux joueurs. Profitez de cette version pour vous améliorer');

        file_put_contents('debug.html', $crawler->html());

        $formActionUrl = $client->getKernel()->getContainer()->get('router')->generate('app_player');
        $formCount = $crawler->filter('form[action="' . $formActionUrl . '"]')->count();
        $this->assertGreaterThan(0, $formCount, 'Formulaire de choix du nom de jeu non trouvé.');

        $form = $crawler->selectButton('Commencer à Jouer')->form();
        $form['gameName'] = 'TestPlayer';
        $client->submit($form);
    }
}
