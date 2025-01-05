<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Entity\Article;
use App\Entity\Category;
use App\Tests\Fixtures\Factory\CategoryFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CategoryBuilder implements BuilderInterface
{
    private ?string $title = null;

    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withArticles(Collection $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Article $article): self
    {
        $this->articles->add($article);

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);

        return $this;
    }

    public function build(bool $persist = true): Category
    {
        $user = CategoryFactory::createOne(array_filter([
            'title' => $this->title,
            'articles' => $this->articles->toArray(),
        ]));

        if ($persist) {
            $user->_save();
        }

        return $user;
    }

    public function getEntityClass(): string
    {
        return Category::class;
    }
}