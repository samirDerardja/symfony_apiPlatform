<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Post;
use Faker;
 

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

         // On configure dans quelles langues nous voulons nos données
         $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true) )
                  ->setCommentaire($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                  ->setCreatedAt($faker->dateTimeAD($max = 'now', $timezone = null))
                  ->setAuteur($faker->firstNameMale);
            $manager->persist($post);
        }
 
        $manager->flush();
    }
}
 