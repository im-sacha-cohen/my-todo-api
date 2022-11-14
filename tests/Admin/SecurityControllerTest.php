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

        /*$token = $crawler->filter('input[name="_csrf_token"]')->extract(array('value'))[0];
        
        $login['email'] = 'user@todo.fr';
        $login['password'] = 'a';
        $login['_csrf_token'] = $token;
        
        $crawler = $client->request('POST', "/login", $login);

        $this->assertResponseHasHeader('Location');
        $this->assertResponseRedirects('/task');*/

        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
            'email' => 'user@todo.fr',
            'password' => 'a',
        ]);
        
        $this->assertResponseRedirects('/task');
    }

    /**
     * @covers App\Controller\SecurityController::logout
     */
    /*public function testAdminLogout() {
        $client = static::createClient();
        $this->loginAdminUser($client);
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Se déconnecter')->link();
        $client->click($link);

        $crawler = $client->followRedirect();

        //$this->assertResponseRedirects('/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Créer une tâche');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Liste des utilisateurs');
        $this->assertSelectorTextNotContains('nav .navbar-collapse .navbar-nav a', 'Créer un utilisateur');
        $this->assertSelectorTextContains('nav .navbar-collapse div a', 'Se connecter');
    }*/
}