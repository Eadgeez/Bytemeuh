<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity as Timestampable;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use Timestampable;

    public function __toString(): string
    {
        return $this->getTitle();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Gedmo\Slug(fields: ['title'])]
    public ?string $slug = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category')]
    private Collection $articles;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childCatergories')]
    private ?self $parentCategory = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentCategory')]
    private Collection $childCatergories;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->childCatergories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory): static
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildCatergories(): Collection
    {
        return $this->childCatergories;
    }

    public function addChildCatergory(self $childCatergory): static
    {
        if (!$this->childCatergories->contains($childCatergory)) {
            $this->childCatergories->add($childCatergory);
            $childCatergory->setParentCategory($this);
        }

        return $this;
    }

    public function removeChildCatergory(self $childCatergory): static
    {
        if ($this->childCatergories->removeElement($childCatergory)) {
            // set the owning side to null (unless already changed)
            if ($childCatergory->getParentCategory() === $this) {
                $childCatergory->setParentCategory(null);
            }
        }

        return $this;
    }
}