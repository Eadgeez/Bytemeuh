<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setSearchFields(['id', 'title'])
            ->setDefaultSort(['id' => 'DESC'])
            ->renderContentMaximized()
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            AssociationField::new('category')
                ->autocomplete()
                ->setLabel('Catégorie')
                ->setSortProperty('title')
                ->setRequired(true)
                ->setHelp('La catégorie de l\'article')
            ,
            TextField::new('slug')->hideOnForm(),
            TextEditorField::new('content'),
            TextEditorField::new('shortDescription'),
            ImageField::new('imageName')->setUploadDir('public/images')->setBasePath('uploads/images')->hideOnIndex(),
            TextField::new('imageURL'),
            TextField::new('imageAlt'),
        ];
    }
}
