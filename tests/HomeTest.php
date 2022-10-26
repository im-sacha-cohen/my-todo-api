<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testHeaderWhenLoggedOut(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Créer une tâche');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Liste des utilisateurs');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Créer un utilisateur');
        $this->assertSelectorTextContains('nav .navbar-collapse div a', 'Se connecter');
    }
}
