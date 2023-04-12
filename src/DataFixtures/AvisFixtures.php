<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture
{
    public int $counter = 1;
    
    public function load(ObjectManager $manager): void
    {
        // $user = new UsersFixtures();

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    
    public function createUser(string $sContenu, User $uUser, ObjectManager $manager): Avis {
        $avis = new Avis();
        $avis->setContenu($sContenu);
        $avis->setUtilisateur($uUser);
       
        $manager->persist($avis);
        // Cette méthode héritée va permettre de mémoriser les utilisateurs pour nous en resservir dans d'autres Fixtures
        $this->addReference('avis-' . $this->counter, $avis);
        $this->counter++;

        return $avis;
    }
}
