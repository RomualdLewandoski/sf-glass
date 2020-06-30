<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WomanController extends AbstractController
{
    /**
     * @Route("/woman", name="woman")
     */
    public function index()
    {
        return $this->render('woman/index.html.twig', [
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg'
        ]);
    }
}
