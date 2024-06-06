<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestsIntegrationTest extends WebTestCase
{
    public function testIntegration()
    {
        // Démarrer le client HTTP
        $client = static::createClient();

        // Aller à la page d'accueil
        $crawler = $client->request('GET', '/');

        // Vérifier que la requête s'est bien passée
        $this->assertResponseIsSuccessful();

        /*// Vérifier que le titre de la page est correct
        $this->assertSelectorTextContains('title', 'Accueil morpion');

        // Vérifier la présence du titre H1 et du paragraphe de description
        $this->assertSelectorTextContains('h1.text-center', 'Bienvenue au Jeu du Morpion');
        $this->assertSelectorTextContains('p.text-center', 'Le jeu du morpion (ou tic-tac-toe) est un jeu simple mais amusant pour deux joueurs. Profitez de cette version pour vous améliorer');

        // Vérifier la présence du formulaire de choix du nom de jeu
        $this->assertCount(1, $crawler->filter('form[action="/app_player"]'));

        // Remplir le formulaire et soumettre
        $form = $crawler->selectButton('Commencer à Jouer')->form();
        $form['gameName'] = 'TestPlayer';
        $client->submit($form);

        // Vérifier que la requête a redirigé (vers la page de jeu)
        $this->assertResponseRedirects('/jouons'); // Adaptez l'URL si nécessaire
        $crawler = $client->followRedirect();

        // Vérifier que nous sommes bien sur la page de jeu
        $this->assertSelectorTextContains('title', 'Jouons !');

        // Vérifier la présence du tableau de morpion
        $this->assertCount(9, $crawler->filter('.tic-tac-toe div'));

        // Vérifier la présence du tableau de classement
        $this->assertSelectorExists('table.table-striped');*/
    }
}
