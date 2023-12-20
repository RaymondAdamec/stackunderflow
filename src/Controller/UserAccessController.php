<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsType;
use App\Form\UserType;
use App\Repository\QuestionsRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader2;

#[Route('/user_questions')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user_questions', methods: ['GET'])]
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

    #[Route('/user', name: 'app_user', methods: ['GET', "POST"])]
    public function userProfile(EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository, FileUploader2 $fileUploader2): Response
    {
        $isBanned = $this->getUser()->getIsBanned();

        if ($isBanned) {
            return $this->render('banned/index.html.twig');
        }
        //get user Id
        $user = $this->getUser();
        if ($user) {
            $userId = $user->getId();
        }

        // find scoring of a specific user for all his/her questions: 
        $userScoringQuestion = $userRepository->findScoringQuestion($userId);

        // find scoring of a specific user for all his/her answers: 
        $userScoringAnswer = $userRepository->findScoringAnswer($userId);

        // summing up the voting of a user for all his/her questions AND answers:
        $totalVoting = (int)$userScoringAnswer['totalVotes'] + (int)$userScoringQuestion['totalVotes'];

        // find all questions of specfic user
        $totalQuestions = $userRepository->findQuestionsOfUser($userId);

        // find all questions of specfic user
        $totalAnswers = $userRepository->findAnswersOfUser($userId);



        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        return $this->render('user_access/user_profile.html.twig', [
            'user' => $user,
            'form' => $form,
            'totalVoting' => $totalVoting,
            'totalQuestions' => $totalQuestions,
            'totalAnswers' => $totalAnswers

        ]);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setEmail($form->get('email')->getData());
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader2->upload($picture);
                $user->setPicture($pictureName);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('user_access/user_profile.html.twig', [
                'user' => $user,
                'form' => $form,
                'totalVoting' => $totalVoting,
                'totalQuestions' => $totalQuestions,
                'totalAnswers' => $totalAnswers

            ]);
        }



        return $this->render('user_access/user_profile.html.twig', [
            'user' => $user,
            'form' => $form

        ]);
    }
}
