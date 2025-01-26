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
        $category = ThereIs::aCategory()->withTitle('Category TEST - FR')->withLocale('fr')->build();
        $category = $category->_real();
        $category->setLocale('en')->setTitle('Category TEST - EN');
        $manager->persist($category);

        for ($i = 0; $i < 5; ++$i) {
            $category = ThereIs::aCategory()->withLocale('fr')->build();
            $category = $category->_real();
            $category->setLocale('en')->setTitle(sprintf('%s - EN', $category->getTitle()));
            $manager->persist($category);
        }

        foreach (CategoryFactory::all() as $category) {
            for ($i = 0; $i < 3; ++$i) {
                $childCategory = ThereIs::aCategory()->withParentCategory($category)->withLocale('fr')->build();
                $childCategory = $childCategory->_real();
                $childCategory->setLocale('en')->setTitle(sprintf('%s - EN', $childCategory->getTitle()));
                $manager->persist($childCategory);
            }
        }

        $manager->flush();
    }
}
