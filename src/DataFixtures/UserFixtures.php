<?php

namespace App\DataFixtures;

use Faker\Factory; 
use App\Entity\User;
use Faker\Provider\DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $manager;
    private $faker;
    private $repositoryLivre;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
            $this->faker = Factory::create("fr_FR");
            $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadUser();
        $manager->flush();
    }

/**
 * Creation des User
 *
 * @return void
 */
    public function loadUser() {

        $genre = ["male","femelle"];
        $commune = [
            "78003", "78005", "78006", "78007", "78009", "78010", "78013", "78015", "78020", "78029",
            "78030", "78031", "78033", "78034", "78036", "78043", "78048", "78049", "78050", "78053", "78057",
            "78062", "78068", "78070", "78071", "78072", "78073", "78076", "78077", "78082", "78084", "78087",
            "78089", "78090", "78092", "78096", "78104", "78107", "78108", "78113", "78117", "78118"
        ];

        for($i=0; $i < 30; $i++) {
            $User = new User();
            $User   ->setNom($this->faker->lastName())
                        ->setPrenom($this->faker->firstName($genre[mt_rand(0,1)]))
                        ->setAdresse($this->faker->streetAddress())
                        ->setTelephone($this->faker->phoneNumber())
                        ->setCodeCommune($commune[mt_rand(0,sizeof($commune)-1)])
                        ->setPassword($this->passwordEncoder->encodePassword($User, $User->getNom()))
                        ->setMail(strtolower($User->getNom())."@gmail.com");
                        $this->addReference("User" .$i, $User);
                        $this->manager->persist($User);

        }

        $userAdmin = new User();
        $rolesADmin[] = USER::ROLE_ADMIN;
           $userAdmin    ->setNom("admin") 
                        ->setPrenom("sam")
                        ->setMail("admin@gmail.com")
                        ->setPassword($this->passwordEncoder->encodePassword($User, $User->getNom()))
                        ->setRoles($rolesADmin);
           $this->manager->persist($userAdmin);

        // $userManager = new User();
        // $rolesManager[] = USER::ROLE_MANAGER;
        //    $userManager   ->setNom("manager")  
        //                 ->setPrenom("samir")
        //                 ->setMail("manager@gmail.com")
        //                 ->setPassword($this->passwordEncoder->encodePassword($user, $user->getNom()))
        //                 ->setRoles($rolesManager);
        //    $this->manager->persist($userManager);

    }
}