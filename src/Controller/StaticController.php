<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('static/home.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
    #[Route('/community', name: 'app_community')]
    public function comunity(): Response
    {
        return $this->render('static/community.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('static/about.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('static/admin.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
}
