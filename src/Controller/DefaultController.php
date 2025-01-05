<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{slug}', name: 'app_category')]
    public function category(string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        return $this->render('category.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{slug}/{articleSlug}', name: 'app_article')]
    public function article(string $slug, string $articleSlug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (null === $category) {
            throw $this->createNotFoundException();
        }

        $article = $category->getArticles()->filter(function ($article) use ($articleSlug) {
            return $article->getSlug() === $articleSlug;
        })->first();


        return $this->render('article.html.twig', [
            'category' => $category,
            'article' => $article,
        ]);
    }
}
