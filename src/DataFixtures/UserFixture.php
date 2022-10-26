<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@todo.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('a')
            ->setUsername('Admin');
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('anonymous@todo.fr')
            ->setRoles(['ROLE_ANONYMOUS'])
            ->setPassword('a')
            ->setUsername('Anonymous');
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@todo.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword('a')
            ->setUsername('User');
        
        $manager->persist($user);

        $manager->flush();
    }
}