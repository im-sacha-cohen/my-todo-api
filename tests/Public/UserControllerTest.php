<?php

namespace App\Tests\Public;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @covers App\Controller\UserController::index
     */
    public function testUserIndex() {
        $client = static::createClient();
        $client->request('GET', '/user');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers App\Controller\UserController::new
     */
    public function testUserNew() {
        $client = static::createClient();
        $client->request('GET', '/user/new');
        $this->assertResponseRedirects('/login');
    }
}