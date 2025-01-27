<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $articles = $articleRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('index.html.twig', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }

    #[Route('/qui-sommes-nous', name: 'app_who_are_we')]
    public function whoAreWe(): Response
    {
        return $this->render('whoAreWe.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_legal_notice')]
    public function legalNotice(): Response
    {
        return $this->render('legalNotice.html.twig');
    }

    #[Route('/conditions-utilisation', name: 'app_terms_of_use')]
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

    #[Route('/sitemap.xml', name: 'app_sitemap', priority: 1)]
    public function sitemap(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $manager): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('app_login'), 'priority' => '1.00'];
        $urls[] = ['loc' => $this->generateUrl('app_register'), 'priority' => '1.00'];
        $urls[] = ['loc' => $this->generateUrl('app_index'), 'priority' => '1.00'];
        $urls[] = ['loc' => $this->generateUrl('app_who_are_we'), 'priority' => '0.80'];
        $urls[] = ['loc' => $this->generateUrl('app_legal_notice'), 'priority' => '0.80'];
        $urls[] = ['loc' => $this->generateUrl('app_terms_of_use'), 'priority' => '0.80'];
        $urls[] = ['loc' => $this->generateUrl('app_categories'), 'priority' => '0.80'];
        $urls[] = ['loc' => $this->generateUrl('app_articles'), 'priority' => '0.80'];

        $xml = $this->renderView('sitemap.xml.twig', [
            'urls' => $urls,
            'hostname' => $hostname
        ]);

        return new Response($xml, 200, [
            'Content-Type' => 'text/xml'
        ]);
    }
}
