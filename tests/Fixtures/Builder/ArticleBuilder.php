<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Entity\Article;
use App\Entity\Category;
use App\Tests\Fixtures\Factory\ArticleFactory;

class ArticleBuilder implements BuilderInterface
{
    private ?string $title = null;
    private ?string $content = null;
    private ?string $shortDescription = null;
    private ?string $imageURL = null;
    private ?string $imageAlt = null;
    private ?Category $category = null;

    public function withContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function withCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function withImageURL(string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function withImageAlt(string $imageAlt): self
    {
        $this->imageAlt = $imageAlt;

        return $this;
    }

    public function build(bool $persist = true): Article
    {
        $user = ArticleFactory::createOne(array_filter([
            'title' => $this->title,
            'content' => $this->content,
            'shortDescription' => $this->shortDescription,
            'imageURL' => $this->imageURL,
            'imageAlt' => $this->imageAlt,
            'category' => $this->category,
        ]));

        if ($persist) {
            $user->_save();
        }

        return $user;
    }

    public function getEntityClass(): string
    {
        return Article::class;
    }
}