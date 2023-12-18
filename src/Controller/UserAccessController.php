<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user_questions')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user', methods: ['GET'])]
    public function index(QuestionsRepository $questionsRepository): Response
    {
        $isBanned = $this->getUser()->getIsBanned();

        if ($isBanned) {
            return $this->render('banned/index.html.twig');
        }
        return $this->render('user_access/index.html.twig', [
            'questions' => $questionsRepository->findAll(),
        ]);
    }
}
