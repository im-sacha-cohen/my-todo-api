<?php

namespace App\Tests\Admin;

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

        $crawler = $client->submitForm('task', [
            'task[title]' => '...',
            'task[content]' => 'jsd'
        ]);

        // select the button
        /*$buttonCrawlerNode = $crawler->selectButton('submit');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        //$token = $form->filter('button.btn-success');
        //dd($form);
        
        // set values on a form object
        $form['task[title]'] = 'Fabien';
        $form['task[content]'] = 'Symfony rocks!';

        // submit the Form object
        $client->submit($form);

        /*$data['task[title]'] = 'Fabien';
        $data['task[content]'] = 'Symfony rocks!';

        $crawler = $client->request('POST', '/task/new', $data);*/

        $this->assertResponseIsSuccessful();
    }
}