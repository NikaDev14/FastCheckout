<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;

class ArticleCrudController extends AbstractCrudController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des articles')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détail de l\'article')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un article')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier l\'article');
    }


    public function configureFields(string $pageName): iterable
    {
        $idField =  IdField::new('id')->hideOnForm();
        $referenceField =  TextField::new('referenceArticle', 'Référence');
        $libelleField =  TextField::new('libelleArticle', 'Libellé');
        $photoArticleField = ImageField::new('photoArticle', 'Image')
            ->setUploadDir('public/assets/img/')
            ->setBasePath('assets/img/');
        $priceField =  NumberField::new('priceArticle', 'Prix');
        $quantityField =  NumberField::new('quantityArticle', 'Quantité(s)');
        $shopField =  AssociationField::new('shop', 'Magasin');

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

        $fields = [
            $idField,
            $referenceField,
            $libelleField,
            $photoArticleField,
            $priceField,
            $quantityField,
            $shopField
        ];

        return $fields;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_ADMIN') || $currentUser->hasRole('ROLE_EMPLOYEE'))) {
            $shop = $currentUser->getShop();

            // Ajouter une condition à la requête pour filtrer les articles par shop
            $queryBuilder->andWhere('entity.shop = :shop')
                ->setParameter('shop', $shop);
        }

        return $queryBuilder;
    }
}
