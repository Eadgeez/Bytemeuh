<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Tests\Fixtures\ThereIs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ThereIs::aUser()->withEmail('admin@gmail.com')->withRoles(['ROLE_ADMIN'])->withPassword('admin')->verified()->build();
        ThereIs::aUser()->withEmail('user@gmail.com')->withRoles(['ROLE_USER'])->withPassword('user')->verified()->build();

        for ($i = 0; $i < 10; ++$i) {
            ThereIs::aUser()->build();
        }
    }
}
