<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Tests\Fixtures\Factory\CategoryFactory;
use App\Tests\Fixtures\ThereIs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 25; ++$i) {
            ThereIs::anArticle()->build();
        }
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
