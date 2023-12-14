<?php


namespace App\Controller;

use App\Entity\Questions;
use App\Entity\RatingsAnswers;
use App\Entity\RatingsQuestions;
use App\Form\RatingsQuestionsType;
use App\Repository\AnswersRepository;
use App\Repository\QuestionsRepository;
use App\Repository\RatingsAnswersRepository;
use App\Repository\RatingsQuestionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ratingsanswers')]
class RatingsAnswerController extends AbstractController
{
    #[Route('/', name: 'app_ratings_answer_index', methods: ['GET'])]
    public function index(RatingsAnswersRepository $ratingsAnswersRepository, UserRepository $userRepository): Response
    {

        return $this->render('ratings_answer/index.html.twig', [
            'ratings_answer' => $ratingsAnswersRepository->findAll(),


        ]);
    }

    #[Route('/voteg/{id}', name: 'app_ratings_answer_voteg', methods: ['GET'])]
    public function voteFunction(RatingsAnswersRepository $ratingsAnswersRepository, EntityManagerInterface $entityManager, $id, AnswersRepository $answersRepository): Response
    {
        $answer = $answersRepository->find($id);
        $user = $this->getUser();
        $ratingsAnswer = new RatingsAnswers();
        $ratingsAnswer->setVotes(1);
        $ratingsAnswer->setFkIdAnswers($answer);
        $ratingsAnswer->setFkIdUser($user);

        $questionId = $answer->getFkIdQuestions()->getId();


        $entityManager->persist($ratingsAnswer);
        $entityManager->flush();

        return $this->redirectToRoute('app_questions_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
    }


    #[Route('/voteb/{id}', name: 'app_ratings_answer_voteb', methods: ['GET'])]
    public function votebadFunction(RatingsAnswersRepository $ratingsAnswersRepository, EntityManagerInterface $entityManager, $id, AnswersRepository $answersRepository): Response
    {
        $answer = $answersRepository->find($id);
        $user = $this->getUser();
        $ratingsAnswer = new RatingsAnswers();
        $ratingsAnswer->setVotes(-1);
        $ratingsAnswer->setFkIdAnswers($answer);
        $ratingsAnswer->setFkIdUser($user);

        $questionId = $answer->getFkIdQuestions()->getId();


        $entityManager->persist($ratingsAnswer);
        $entityManager->flush();

        return $this->redirectToRoute('app_questions_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
    }
}
