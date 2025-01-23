<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Tests\Fixtures\Factory\CategoryFactory;
use App\Tests\Fixtures\ThereIs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; ++$i) {
            ThereIs::aCategory()->build();
        }

        foreach (CategoryFactory::all() as $category) {
            for ($i = 0; $i < 3; ++$i) {
                ThereIs::aCategory()->withParentCategory($category)->build();
            }
        }
    }
}
