<?php

namespace App\Controller\Admin;

use App\Entity\Shop;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;

class ShopCrudController extends AbstractCrudController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Shop::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des magasins')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détail du magasin')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un magasin')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier le magasin');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('referenceShop', 'Référence'),
            TextField::new('nameShop', 'Nom'),
            ImageField::new('photoShop', 'Image')
                ->setUploadDir('public/assets/img/')
                ->setBasePath('assets/img/'),
            AssociationField::new('articlesShop', 'Article(s)')
                ->onlyOnIndex(),
            TextField::new('address', 'Adresse'),
            TextField::new('zipCode', 'Code Postal'),
            TextField::new('city', 'Ville'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');

    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_ADMIN') || $currentUser->hasRole('ROLE_EMPLOYEE'))) {
            $shop = $currentUser->getShop();

            // Ajouter une condition à la requête pour filtrer les shops par shop
            $queryBuilder->andWhere('entity.id = :shop')
                ->setParameter('shop', $shop);
        }

        return $queryBuilder;
    }
}
