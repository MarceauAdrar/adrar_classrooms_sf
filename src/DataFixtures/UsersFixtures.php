<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public int $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createUser("RODRIGUES", "Marceau", "marceaurodrigues@adrar-formation.com", array("ROLE_DEV", "ROLE_ADMIN"), "adrar", "default.png", $manager);
       
        $this->createUser("STAGIAIRES", "Les", "les-stagiaires@adrar-formation.com", array("ROLE_STAGIAIRE"), "adrar", "default.png", $manager);

        $manager->flush();
    }

    public function createUser(string $sNom, string $sPrenom, string $sEmail, array $arrRoles, string $sPassword, string $sImage, ObjectManager $manager): User {
        $user = new User();
        $user->setNom($sNom);
        $user->setPrenom($sPrenom);
        $user->setEmail($sEmail);
        $user->setRoles($arrRoles);
        $user->setPassword(password_hash($sPassword, PASSWORD_BCRYPT));
        $user->setImage($sImage);
       
        $manager->persist($user);
        // Cette méthode héritée va permettre de mémoriser les utilisateurs pour nous en resservir dans d'autres Fixtures
        $this->addReference('user-' . $this->counter, $user);
        $this->counter++;

        return $user;
    }

}
