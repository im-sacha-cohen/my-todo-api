<?php

namespace App\Tests\Admin;

use App\Tests\Admin\AbstractAdmin;

class SecurityControllerTest extends AbstractAdmin
{
    /**
     * @covers App\Controller\SecurityController::login
     */
    public function testAdminLogin() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $token = $crawler->filter('input[name="_csrf_token"]')->extract(array('value'))[0];
        
        $login['email'] = 'user@todo.fr';
        $login['password'] = 'a';
        $login['_csrf_token'] = $token;
        
        $crawler = $client->request('POST', "/login", $login);

        $this->assertResponseHasHeader('Location');
        $this->assertResponseRedirects('/task');
    }

    /**
     * @covers App\Controller\HomeController::index
     */
    public function testAdminIndex() {
        $client = static::createClient();
        $this->loginAdminUser($client);

        $client->request('GET', '/task');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('nav', 'Liste des tâches');
        $this->assertSelectorTextContains('nav .navbar-collapse .navbar-nav', 'Créer une tâche');
        $this->assertSelectorTextContains('nav .navbar-collapse .navbar-nav', 'Liste des utilisateurs');
        $this->assertSelectorTextContains('nav .navbar-collapse .navbar-nav', 'Créer un utilisateur');
        $this->assertSelectorTextNotContains('nav .navbar-collapse div', 'Se connecter');
        $this->assertSelectorTextContains('nav .navbar-collapse div', 'Se déconnecter');
    }
}