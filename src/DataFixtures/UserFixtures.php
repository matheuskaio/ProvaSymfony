<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setUsername("admin")->setPassword('$argon2id$v=19$m=65536,t=4,p=1$b2ZTSVdEWnlmNFRNWkNraA$lSg+s046vXiaG4eg04mQRN6oTXqH3yZOnFVUE0bb9Ko');
        $manager->persist($user);
        $manager->flush();
    }
}
