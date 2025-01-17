<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Factory;

use App\Entity\Article;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Article>
 */
final class ArticleFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Article::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->words(self::faker()->numberBetween(1, 5), true),
            'content' => self::faker()->text(70),
            'shortDescription' => self::faker()->text(300),
            'imageURL' => 'https://picsum.photos/id/237/900/'.self::faker()->randomNumber(3, true),
            'category' => CategoryFactory::randomOrCreate(),
        ];
    }

    protected function initialize(): static
    {
        return $this
            ->withoutPersisting()
            // ->afterInstantiate(function(User $user): void {})
        ;
    }
}
