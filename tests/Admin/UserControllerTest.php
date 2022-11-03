<?php

namespace App\Tests\Admin;

use App\Repository\UserRepository;
use App\Tests\Admin\AbstractAdmin;

class UserControllerTest extends AbstractAdmin
{
    /**
     * @covers App\Controller\UserController::index
     */
    public function testUserIndex() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);
        $crawler = $client->request('GET', '/user');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers App\Controller\UserController::new
     */
    public function testUserNew() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);
        $crawler = $client->request('GET', '/user/new');
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="user[_token]"]')->extract(array('value'))[0];
        
        $user['user']['email'] = 'test@todo.fr';
        $user['user']['username'] = 'Test user';
        $user['user']['password']['first'] = '123456';
        $user['user']['password']['second'] = '123456';
        $user['user']['roles'] = ['ROLE_USER'];
        $user['user']['_token'] = $token;

        $crawler = $client->request('POST', '/user/new', $user);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'L\'utilisateur a bien été ajouté.');
    }

    /**
     * @covers App\Controller\UserController::edit
     */
    public function testUserEdit() {
        $client = static::createClient();
        $this->loginAdminUser($client);
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userObject = $userRepository->findOneByEmail('test@todo.fr');
        $userId = $userObject->getId();
        
        $crawler = $client->request('GET', "/user/$userId/edit");
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="user[_token]"]')->extract(array('value'))[0];
        
        $user['user']['email'] = 'contact@sacha-cohen.fr';
        $user['user']['username'] = 'Test user';
        $user['user']['password']['first'] = '123456';
        $user['user']['password']['second'] = '123456';
        $user['user']['roles'] = ['ROLE_USER'];
        $user['user']['_token'] = $token;

        $crawler = $client->request('POST', "/user/$userId/edit", $user);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'L\'utilisateur a bien été modifié.');
    }

    /**
     * @covers App\Controller\UserController::delete
     */
    public function testUserDelete() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $userObject = $userRepository->findOneBy(['email' => 'contact@sacha-cohen.fr']);
        $userId = $userObject->getId();

        $crawler = $client->request('GET', "/user/$userId/edit");
        
        $token = $crawler->filter('input[name="_token"]')->extract(array('value'))[0];
        
        $user['_token'] = $token;

        $crawler = $client->request('POST', "/user/$userId/delete", $user);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', "Superbe ! L'utilisateur a bien été supprimé.");
    }
}