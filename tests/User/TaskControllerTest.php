<?php

namespace App\Tests\User;

use App\Entity\Task;
use App\Tests\User\AbstractUser;
use App\Repository\TaskRepository;

class TaskControllerTest extends AbstractUser
{
    /**
     * @covers App\Controller\TaskController::new
     */
    public function testTaskNew() {
        $client = static::createClient();
        
        $this->loginUser($client);
        $crawler = $client->request('GET', '/task/new');
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];
        
        $task['task']['title'] = 'Test task 2';
        $task['task']['content'] = 'My ID should be equal to 2';
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
        
        $this->loginUser($client);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task 2']);
        $taskId = $taskObject->getId();

        $crawler = $client->request('GET', "/task/$taskId/edit");
        $this->assertResponseIsSuccessful();
        
        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];
        
        $task['task']['title'] = 'Test task 2 edited';
        $task['task']['content'] = 'My ID is equal to 2';
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
        
        $this->loginUser($client);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task 2 edited']);
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
        
        $this->loginUser($client);
        $crawler = $client->request('GET', '/task');

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskObject = $taskRepository->findOneBy(['title' => 'Test task 2 edited']);
        $taskId = $taskObject->getId();
        
        $token = $crawler->filter('input[name="_token"]')->extract(array('value'))[0];
        
        $task['_token'] = $token;

        $crawler = $client->request('POST', "/task/$taskId/delete", $task);
    
        $this->assertResponseHasHeader('Location');
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'La tâche a bien été supprimée.');
    }
}