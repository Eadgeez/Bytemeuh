<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Entity\Article;
use App\Entity\Category;
use App\Tests\Fixtures\Factory\ArticleFactory;
use Zenstruck\Foundry\Persistence\Proxy;

class ArticleBuilder implements BuilderInterface
{
    private ?string $title = null;
    private ?string $content = null;
    private ?string $shortDescription = null;
    private ?string $imageURL = null;
    private ?Category $category = null;
    private ?string $locale = null;

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

    public function withLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Proxy<Article>|Article
     */
    public function build(bool $persist = true): Proxy|Article
    {
        $user = ArticleFactory::createOne(array_filter([
            'title' => $this->title,
            'content' => $this->content,
            'shortDescription' => $this->shortDescription,
            'imageURL' => $this->imageURL,
            'category' => $this->category,
            'locale' => $this->locale,
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