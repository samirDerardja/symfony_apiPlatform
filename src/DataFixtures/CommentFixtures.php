<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Comment; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

         // On configure dans quelles langues nous voulons nos données
         $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $post = new Comment();
            $post->setAuteur($faker->firstNameMale)
                    ->setMail(strtolower($post->getAuteur())."@gmail.com")
                    ->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                    ->setCreateAt($faker->dateTimeAD($max = 'now', $timezone = null));
                    
            $manager->persist($post);
        }
 
        $manager->flush();
    }
}
