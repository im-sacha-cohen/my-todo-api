<?php

namespace App\Tests\Admin;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Tests\Admin\AbstractAdmin;

class TaskControllerTest extends AbstractAdmin
{
    /**
     * @covers App\Controller\TaskController::new
     */
    public function testTaskNew() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);
        $crawler = $client->request('GET', '/task/new');
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];
        
        $task['task']['title'] = 'Test task';
        $task['task']['content'] = 'My ID should be equal to 1';
        $task['task']['_token'] = $token;

        $crawler = $client->request('POST', '/task/new', $task);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'La tâche a été bien été ajoutée.');
    }

    /**
     * @covers App\Controller\TaskController::edit
     */
    public function testTaskEdit() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task']);
        $taskId = $taskObject->getId();

        $crawler = $client->request('GET', "/task/$taskId/edit");
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];
        
        $task['task']['title'] = 'Test task edited';
        $task['task']['content'] = 'My ID is equal to 1';
        $task['task']['_token'] = $token;

        $crawler = $client->request('POST', "/task/$taskId/edit", $task);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'La tâche a bien été modifiée.');
    }

    /**
     * @covers App\Controller\TaskController::toggleTaskAction
     */
    public function testTaskToggle() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task edited']);
        $taskId = $taskObject->getId();
        
        $client->request('GET', "/task/$taskId/toggle");
    
        $this->assertResponseHasHeader('Location');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'La tâche a bien changé d\état !');
    }

    /**
     * @covers App\Controller\TaskController::delete
     */
    public function testTaskDelete() {
        $client = static::createClient();
        
        $this->loginAdminUser($client);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task edited']);
        $taskId = $taskObject->getId();

        $crawler = $client->request('GET', '/task');
        
        $token = $crawler->filter('input[name="_token"]')->extract(array('value'))[0];
        
        $task['_token'] = $token;

        $crawler = $client->request('POST', "/task/$taskId/delete", $task);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'La tâche a bien été supprimée.');
    }
}