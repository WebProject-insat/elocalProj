<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i=0;$i<30;$i++) {
            $ad = new Ad();
            $title= $faker->sentence(5);
            $ad->setTitle($title)
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setIntroduction($faker->realText())
                ->setContent('<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>')
                ->setPrice(mt_rand(250,800))
                ->setRooms(mt_rand(1,5));

            for($j=0;$j<mt_rand(2,5);$j++){
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
