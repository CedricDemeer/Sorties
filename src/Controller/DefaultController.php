<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'accueil')]
    public function accueil()
    {
        return $this->render("default/accueil.html.twig");
    }
/*
    #[Route('/', name: 'all')]
    public function smartphone()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) )
        {
            $isSmartphone = true;
            var_dump('balabal');
        }
        else {
            $isSmartphone = false;
        }

        return $this->render("inc/stylesheet.html.twig", [
            "isSmartphone" => $isSmartphone,
        ]);
    }*/
}
