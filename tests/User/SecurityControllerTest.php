<?php

namespace App\Tests\User;

use App\Tests\User\AbstractUser;

class SecurityControllerTest extends AbstractUser
{
    /**
     * @covers App\Controller\SecurityController::login
     */
    public function testAdminLogin() {
        $client = static::createClient();
        $this->loginUser($client);

        $client->request('GET', '/task');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('nav', 'Liste des tâches');
        $this->assertSelectorTextContains('nav .navbar-collapse .navbar-nav', 'Créer une tâche');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav', 'Liste des utilisateurs');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav', 'Créer un utilisateur');
        $this->assertSelectorTextNotContains('nav .navbar-collapse div', 'Se connecter');
        $this->assertSelectorTextContains('nav .navbar-collapse div', 'Se déconnecter');
    }
}