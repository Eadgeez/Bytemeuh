<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

interface BuilderInterface
{
    public function build(bool $persist = true): object;
    public function getEntityClass(): string;
}