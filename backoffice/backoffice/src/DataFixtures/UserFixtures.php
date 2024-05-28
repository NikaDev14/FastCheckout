<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('username '.$i.'@sample.com');
            $user->setFirstName('Prénom '.$i);
            $user->setLastName('Nom '.$i);
            $user->setAddress($i. ' Rue du Pont');
            $user->setZipCode('75001');
            $user->setCity('Paris');
            $user->setPhoneNumber('010000000'.$i);
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
            $manager->persist($user);
        }

        $user_bis = new User();
        $user_bis->setEmail('user_bis'.'@sample.com');
        $user_bis->setFirstName('User');
        $user_bis->setLastName('Bis ');
        $user_bis->setAddress('Rue du Pont');
        $user_bis->setCity('Paris');
        $user_bis->setZipCode('75001');
        $user_bis->setPhoneNumber('0100000000');
        $password_bis = $this->hasher->hashPassword($user_bis, 'user-bis-password');
        $user_bis->setPassword($password_bis);
        $this->addReference('user.bis', $user_bis);
        $manager->persist($user_bis);
        $manager->flush();

        //Create SUPER ADMIN USER
        $superAdminUser = new User();
        $superAdminUser->setEmail('superadmin'.'@superadmin.fr');
        $superAdminUser->setFirstName('Super');
        $superAdminUser->setLastName('Admin ');
        $superAdminUser->setAddress('Rue du Pont');
        $superAdminUser->setCity('Paris');
        $superAdminUser->setZipCode('75001');
        $superAdminUser->setPhoneNumber('0100000000');
        $password_bis = $this->hasher->hashPassword($superAdminUser, '123456');
        $superAdminUser->setPassword($password_bis);
        $superAdminUser->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($superAdminUser);
        $manager->flush();

        //Create ADMIN USER
        $adminUser = new User();
        $adminUser->setEmail('admin'.'@admin.fr');
        $adminUser->setFirstName('Admin');
        $adminUser->setLastName('Admin ');
        $adminUser->setAddress('Rue du Pont');
        $adminUser->setCity('Paris');
        $adminUser->setZipCode('75001');
        $adminUser->setPhoneNumber('0100000000');
        $password_bis = $this->hasher->hashPassword($adminUser, '123456');
        $adminUser->setPassword($password_bis);
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setShop($this->getReference('shop.bis'));
        $manager->persist($adminUser);
        $manager->flush();

        //Create EMPLOYEE USER
        $employeeUser = new User();
        $employeeUser->setEmail('employee'.'@employee.fr');
        $employeeUser->setFirstName('Employee');
        $employeeUser->setLastName('Employee ');
        $employeeUser->setAddress('Rue du Pont');
        $employeeUser->setCity('Paris');
        $employeeUser->setZipCode('75001');
        $employeeUser->setPhoneNumber('0100000000');
        $password_bis = $this->hasher->hashPassword($employeeUser, '123456');
        $employeeUser->setPassword($password_bis);
        $employeeUser->setRoles(['ROLE_EMPLOYEE']);
        $employeeUser->setShop($this->getReference('shop.bis'));
        $manager->persist($employeeUser);
        $manager->flush();
    }
}
