<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('Kazuma');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('$2y$13$HR2uXf/fiOHZTGSm0ijkVOrNlWJuFRSqZ7ptZvwngtsJY.J6KVMGW');
        $manager->persist($admin);

        $manager->flush();
    }
}
