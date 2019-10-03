<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/listeUsers", name="listeUsers")
     */
    public function listeUsers(SerializerInterface $serializer)
    {

    
        //récuperation de l api region 
        $myUsers = file_get_contents('http://randomuser.me/api/?gender=female');
        // on decode l api via un serializer 
        $myUsersTab = $serializer->decode($myUsers, 'json');
       
        dump($myUsersTab);
        die();
        return $this->render('user/user.html.twig', [
            'myUsers' => $myUsers
        ]);
    }

}
