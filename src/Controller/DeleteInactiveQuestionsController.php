<?php

namespace App\Controller;

use App\Repository\AnswersRepository;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteInactiveQuestionsController extends AbstractController
{
    public function deleteInactiveQuestions(QuestionsRepository $questionsRepository, EntityManagerInterface $entityManager): Response
    {
        $inactiveQuestions = $questionsRepository->findInactiveQuestions();
        // dd($inactiveQuestions);
        foreach ($inactiveQuestions as $question) {
            $entityManager->remove($question);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_home'); // Replace 'home' with the route you want to redirect to
    }
}
