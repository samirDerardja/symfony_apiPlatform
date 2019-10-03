<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     *@Route("/", name="login")
     */
    public function loginAction()
    {
        return $this->render('security/login.html.twig');
    }


    /**
     *@Route("/logout")
     *@throws \RuntimeException
     */

    public function logout()
    {
        throw new \RuntimeException('this should nenver be called');
    }
}
