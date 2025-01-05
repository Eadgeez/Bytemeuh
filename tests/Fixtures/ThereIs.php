<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\Tests\Fixtures\Builder\ArticleBuilder;
use App\Tests\Fixtures\Builder\CategoryBuilder;
use App\Tests\Fixtures\Builder\UserBuilder;

class ThereIs
{
    public static function aUser(): UserBuilder
    {
        return new UserBuilder();
    }

    public static function aCategory(): CategoryBuilder
    {
        return new CategoryBuilder();
    }

    public static function anArticle(): ArticleBuilder
    {
        return new ArticleBuilder();
    }


    public static function anImagePath(?string $label = null, int $width = 320, int $height = 320, ?string $colorStart = null, ?string $colorEnd = null): string
    {
        $randColor = static function(): string {
            return substr(md5((string)random_int(0, PHP_INT_MAX)), 0, 6);
        };

        return sprintf(
            "https://placeholder.pics/svg/%sx%s/%s-%s/FFFFFF-FFFFFF/%s",
            $width,
            $height,
            $colorStart ?? $randColor(),
            $colorEnd ?? $randColor(),
            $label
        );
    }
}