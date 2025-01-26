<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $articles = $articleRepository->findBy([], ['id' => 'DESC'], 5);

        return $this->render('index.html.twig', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }

    #[Route([
        'fr'=>'/mentions-legales',
        'en'=>'/legal-notice'
    ],
        name: 'app_legal_notice'
    )]
    public function legalNotice(): Response
    {
        return $this->render('legalNotice.html.twig');
    }

    #[Route([
        'fr'=>'/conditions-utilisation',
        'en'=>'/terms-of-use'
    ],
        name: 'app_terms_of_use'
    )]
    public function termsOfUse(): Response
    {
        return $this->render('termsOfUse.html.twig');
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/articles', name: 'app_articles')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/{slug}', name: 'app_category')]
    public function category(string $slug, EntityManagerInterface $entityManager): Response
    {
        $translationsRepository = $entityManager->getRepository('Gedmo\Translatable\Entity\Translation');

        /** @var Category|null $category */
        $category = $translationsRepository->findObjectByTranslatedField('slug', $slug, Category::class);

        if (null === $category) {
            throw $this->createNotFoundException();
        }

        if ($category->getSlug() !== $slug) {
            return $this->redirectToRoute('app_category', ['slug' => $category->getSlug()]);
        }

        return $this->render('category.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{slug}/{articleSlug}', name: 'app_article')]
    public function article(string $slug, string $articleSlug, EntityManagerInterface $entityManager): Response
    {
        $translationsRepository = $entityManager->getRepository('Gedmo\Translatable\Entity\Translation');

        /** @var Category|null $category */
        $category = $translationsRepository->findObjectByTranslatedField('slug', $slug, Category::class);

        if (null === $category) {
            throw $this->createNotFoundException();
        }

        if ($category && $category->getSlug() !== $slug) {
            return $this->redirectToRoute('app_article', ['slug' => $category->getSlug(), 'articleSlug' => $articleSlug]);
        }

        /** @var Article|null $article */
        $article = $translationsRepository->findObjectByTranslatedField('slug', $articleSlug, Article::class);

        if (null === $article) {
            throw $this->createNotFoundException();
        }

        if ($article->getCategory()->getId() !== $category->getId()) {
            throw $this->createNotFoundException();
        }

        if ($article->getSlug() !== $articleSlug) {
            return $this->redirectToRoute('app_article', ['slug' => $slug, 'articleSlug' => $article->getSlug()]);
        }

        return $this->render('article.html.twig', [
            'category' => $category,
            'article' => $article,
        ]);
    }
}