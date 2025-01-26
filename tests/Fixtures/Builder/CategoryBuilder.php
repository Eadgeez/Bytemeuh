<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Entity\Article;
use App\Entity\Category;
use App\Tests\Fixtures\Factory\CategoryFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zenstruck\Foundry\Persistence\Proxy;

class CategoryBuilder implements BuilderInterface
{
    private ?string $title = null;

    private Collection $articles;
    private ?Category $parentCategory = null;
    private Collection $childCategories;
    private ?string $locale = null;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->childCategories = new ArrayCollection();
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

    public function withParentCategory(Category $parentCategory): self
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    public function withChildCategories(Collection $childCategories): self
    {
        $this->childCategories = $childCategories;

        return $this;
    }

    public function addChildCategory(Category $childCategory): self
    {
        $this->childCategories->add($childCategory);

        return $this;
    }

    public function removeChildCategory(Category $childCategory): self
    {
        $this->childCategories->removeElement($childCategory);

        return $this;
    }

    public function withLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Proxy<Category>|Category
     */
    public function build(bool $persist = true): Proxy|Category
    {
        $category = CategoryFactory::createOne(array_filter([
            'title' => $this->title,
            'articles' => $this->articles->toArray(),
            'parentCategory' => $this->parentCategory,
            'childCategories' => $this->childCategories->toArray(),
            'locale' => $this->locale,
        ]));

        if ($persist) {
            $category->_save();
        }

        return $category;
    }

    public function getEntityClass(): string
    {
        return Category::class;
    }
}