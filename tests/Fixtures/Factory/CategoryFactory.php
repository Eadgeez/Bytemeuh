<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Factory;

use App\Entity\Category;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Category>
 */
final class CategoryFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Category::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'title' => 'CAT'.self::faker()->words(self::faker()->numberBetween(1, 4), true),
            'locale' => 'fr',
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
