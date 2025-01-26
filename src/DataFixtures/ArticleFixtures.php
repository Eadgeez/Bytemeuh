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
        $article = ThereIs::anArticle()->withTitle('Article TEST - FR')->withLocale('fr')->build();
        $article = $article->_real();
        $article->setLocale('en')->setTitle('Article TEST - EN');
        $manager->persist($article);

        foreach (CategoryFactory::all() as $category) {
            for ($i = 0; $i < 10; ++$i) {
                $article = ThereIs::anArticle()->withCategory($category)->withLocale('fr')->build();
                $article = $article->_real();
                $article->setLocale('en')->setTitle(sprintf('%s - EN', $category->getTitle()));
                $manager->persist($article);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
