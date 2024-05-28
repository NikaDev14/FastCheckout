<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Type\CurrentUserRolesType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Security;

class UserCrudController extends AbstractCrudController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $currentUser = $this->security->getUser();

        $idField = IdField::new('id')->hideOnForm();
        $emailField = TextField::new('email');
        $firstNameField = TextField::new('firstName', 'Prénom');
        $lastNameField = TextField::new('lastName', 'Nom');
        $addressField = TextField::new('address', 'Adresse')->hideOnIndex();
        $zipCodeField = TextField::new('zipCode', 'Code Postal');
        $cityField = TextField::new('city', 'Ville');
        $phoneNumberField = TextField::new('phoneNumber', 'Numéro de téléphone');
        $passwordField = TextField::new('password')
        ->hideOnIndex();
        $roles = $currentUser->getRoles();
        $rolesChoices = array_combine($roles, $roles);
        $rolesField = ChoiceField::new('roles');
        $rolesFieldOptions = [
            'choices' => $rolesChoices,
            'multiple' => true,
            'expanded' => true,
        ];
        $rolesField->setFormTypeOptions($rolesFieldOptions)->onlyOnForms();

        $shopField = AssociationField::new('shop', 'Magasin');

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
            $emailField,
            $passwordField,
            $rolesField,
            $shopField,
            $firstNameField,
            $lastNameField,
            $addressField,
            $zipCodeField,
            $cityField,
            $phoneNumberField,
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
         $actions
             ->add(Crud::PAGE_INDEX, Action::DETAIL)
             ->remove(Crud::PAGE_INDEX, Action::NEW)
             ->remove(Crud::PAGE_INDEX, Action::DELETE);


        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_SUPER_ADMIN')) || $currentUser->hasRole('ROLE_ADMIN')) {

            $actions
                ->add(Crud::PAGE_INDEX, Action::NEW)
                ->add(Crud::PAGE_INDEX, Action::DELETE);

        }

         return $actions;

    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $currentUser = $this->security->getUser();

        if ($currentUser && ($currentUser->hasRole('ROLE_ADMIN'))) {
            $shop = $currentUser->getShop();
            // Ajouter une condition à la requête pour filtrer les users par shop
            $queryBuilder->andWhere('entity.shop = :shop')
                ->setParameter('shop', $shop);
        }
        elseif ($currentUser && $currentUser->hasRole('ROLE_EMPLOYEE')){
            $user = $currentUser->getId();
            // Ajouter une condition à la requête pour filtrer les users par id
            $queryBuilder->andWhere('entity.id = :id')
                ->setParameter('id', $user);
        }

        return $queryBuilder;
    }
}
