<?php

namespace App\Tests\User;

use App\Tests\User\AbstractUser;

class UserControllerTest extends AbstractUser
{
    /**
     * @covers App\Controller\UserController::index
     */
    public function testUserIndex() {
        $client = static::createClient();
        
        $this->loginUser($client);
        $crawler = $client->request('GET', '/user');
        $this->assertResponseStatusCodeSame(403);
    }
}