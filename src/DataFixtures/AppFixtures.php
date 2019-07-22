<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $profiles = ['SALON','PARTICULIER'];
        foreach ($profiles as $profile){
            $pro = new Profile();
            $pro->setName($profile);
            $manager->persist($pro);
        }
        $statusArray =['emise','payée','annulée'];
        foreach ($statusArray as $statusName){
            $status = new Status();
            $status->setStatusName($statusName);
            $manager->persist($status);
        }
        



        $manager->flush();
    }
}
