<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Categories')
            ->setSearchFields(['id', 'title'])
            ->setDefaultSort(['id' => 'DESC'])
            ->renderContentMaximized()
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            AssociationField::new('parentCategory')
                ->autocomplete()
                ->setLabel('Catégorie')
                ->setSortProperty('title')
                ->setHelp('Categorie parent de la catégorie'),
            AssociationField::new('childCatergories')
                ->autocomplete()
                ->setLabel('Catégorie')
                ->setSortProperty('title')
                ->setHelp('Categories enfant de la catégorie'),
            TextField::new('slug')->hideOnForm(),
        ];
    }
}
