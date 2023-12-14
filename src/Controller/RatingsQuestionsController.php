<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Entity\RatingsQuestions;
use App\Form\RatingsQuestionsType;
use App\Repository\QuestionsRepository;
use App\Repository\RatingsQuestionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ratingsquestions')]
class RatingsQuestionsController extends AbstractController
{
    #[Route('/', name: 'app_ratings_questions_index', methods: ['GET'])]
    public function index(RatingsQuestionsRepository $ratingsQuestionsRepository, UserRepository $userRepository): Response
    {

        return $this->render('ratings_questions/index.html.twig', [
            'ratings_questions' => $ratingsQuestionsRepository->findAll(),


        ]);
    }

    #[Route('/voteg/{id}', name: 'app_ratings_questions_voteg', methods: ['GET'])]
    public function voteFunction(RatingsQuestionsRepository $ratingsQuestionsRepository, EntityManagerInterface $entityManager, $id, QuestionsRepository $questionsRepository): Response
    {
        $question = $questionsRepository->find($id);
        $user = $this->getUser();

        $ratingsQuestion = new RatingsQuestions();
        $ratingsQuestion->setVotes(1);
        $ratingsQuestion->setFkIdQuestion($question);
        $ratingsQuestion->setFkIdUser($user);


        $entityManager->persist($ratingsQuestion);
        $entityManager->flush();

        return $this->redirectToRoute('app_ratings_questions_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/voteb/{id}', name: 'app_ratings_questions_voteb', methods: ['GET'])]
    public function votebadFunction(RatingsQuestionsRepository $ratingsQuestionsRepository, EntityManagerInterface $entityManager, $id, QuestionsRepository $questionsRepository): Response
    {
        $question = $questionsRepository->find($id);
        $user = $this->getUser();

        $ratingsQuestion = new RatingsQuestions();
        $ratingsQuestion->setVotes(-1);
        $ratingsQuestion->setFkIdQuestion($question);
        $ratingsQuestion->setFkIdUser($user);


        $entityManager->persist($ratingsQuestion);
        $entityManager->flush();

        return $this->redirectToRoute('app_ratings_questions_index', [], Response::HTTP_SEE_OTHER);
    }
}
