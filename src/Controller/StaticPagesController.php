<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends AbstractController
{
    #[Route('/home', name: 'app_static_home')]
    public function index(): Response
    {
        return $this->render('static_pages/home.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]);
    }

    #[Route('/comunity', name: 'app_static_comunity')]
    public function comunity(): Response
    {
        return $this->render('static_pages/comunity.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]);
    }

    #[Route('/about', name: 'app_static_about')]
    public function about(): Response
    {
        return $this->render('static_pages/about.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]);
    }
}
