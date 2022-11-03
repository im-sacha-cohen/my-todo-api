<?php

namespace App\Tests\Public;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordControllerTest extends WebTestCase
{
    /**
     * @covers App\Controller\ResetPasswordController::request
     */
    public function testResetRequest() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reset-password');
        $this->assertResponseIsSuccessful();

        $token = $crawler->filter('input[name="reset_password_request_form[_token]"]')->extract(array('value'))[0];

        $reset['reset_password_request_form']['email'] = 'contact@sacha-cohen.fr';
        $reset['reset_password_request_form']['_token'] = $token;
        
        $crawler = $client->request('POST', '/reset-password', $reset);

        $this->assertResponseHasHeader('Location');
        $this->assertResponseRedirects('/reset-password/check-email');
    }

    /**
     * @covers App\Controller\ResetPasswordController::checkEmail
     */
    public function testResetCheckEmail() {
        $client = static::createClient();
        $client->request('GET', '/reset-password/check-email');

        $this->assertResponseIsSuccessful();
    }
}