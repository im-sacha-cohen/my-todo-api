<?php

namespace App\Tests\Public;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * @covers App\Controller\TaskController::index
     */
    public function testTaskIndex() {
        $client = static::createClient();
        $client->request('GET', '/task');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers App\Controller\TaskController::new
     */
    public function testTaskNew() {
        $client = static::createClient();
        $client->request('GET', '/task/new');
        $this->assertResponseRedirects('/login');
    }

    // This lines below required database request on tasks.

    /**
     * @covers App\Controller\TaskController::edit
     */
    /*public function testTaskEdit() {
        $client = static::createClient();
        $client->request('GET', '/task/1/edit');
        $this->assertResponseRedirects('/login');
    }*/

    /**
     * @covers App\Controller\TaskController::delete
     */
    /*public function testTaskDelete() {
        $client = static::createClient();
        $client->request('POST', '/task/1/delete');
        $this->assertResponseRedirects('/login');
    }*/
}