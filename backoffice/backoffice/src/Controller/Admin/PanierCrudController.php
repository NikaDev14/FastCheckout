<?php

namespace App\Controller\Admin;

use App\Entity\Cart;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Security\Core\Security;

class PanierCrudController extends AbstractCrudController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Cart::class;

    }


    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des paniers')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détail du panier')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un panier')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier le panier');
    }

    public function configureFields(string $pageName): iterable
    {
        $idField = IdField::new('id')
            ->hideOnForm();
        $cartArticlesField = AssociationField::new('cartArticles', 'Article(s)')
            ->hideOnIndex();

        $shopField = AssociationField::new('shop', 'Magasin');

        $amoutField = NumberField::new('totalAmount', 'Prix Total');

        $activeField = BooleanField::new('isActive', 'Actif');

        $validateField = BooleanField::new('isValidate', 'Valider');

        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_ADMIN') || $currentUser->hasRole('ROLE_EMPLOYEE'))) {
            $shop = $currentUser->getShop();

            $shopField->setQueryBuilder(function (QueryBuilder $builder) use ($shop) {
                $alias = $builder->getRootAliases()[0];

                return $builder
                    ->andWhere("$alias.id = :shopId")
                    ->setParameter('shopId', $shop->getId());
            });

        }

        return [
            $idField,
            $cartArticlesField,
            $shopField,
            $amoutField,
            $activeField,
            $validateField,
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);

    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_ADMIN') || $currentUser->hasRole('ROLE_EMPLOYEE'))) {
            $shop = $currentUser->getShop();

            // Ajouter une condition à la requête pour filtrer les paniers par shop
            $queryBuilder->andWhere('entity.shop = :shop')
                ->setParameter('shop', $shop);
        }

        return $queryBuilder;
    }
}
