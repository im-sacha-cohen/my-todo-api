<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractAdmin extends WebTestCase {
    private function getAdminUser(): User {
        $userRepository = static::getContainer()->get(UserRepository::class);
        return $userRepository->findOneByEmail('user@todo.fr');
    }

    protected function loginAdminUser(KernelBrowser $client) {
        $client->loginUser($this->getAdminUser());
    }
}