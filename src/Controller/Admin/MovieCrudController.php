<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Movie')
            ->setEntityLabelInPlural('Movie')
            ->setSearchFields(['id', 'title']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $genres = AssociationField::new('genres');
        $id = IntegerField::new('id', 'ID');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $employments = AssociationField::new('employments');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $createdAt, $updatedAt, $genres, $employments];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $genres];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $genres];
        }
    }
}
