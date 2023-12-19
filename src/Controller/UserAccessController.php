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

    #[Route('/user', name: 'app_user', methods: ['GET', "POST"])]
    public function userProfile(EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository): Response
    {
        $isBanned = $this->getUser()->getIsBanned();

        if ($isBanned) {
            return $this->render('banned/index.html.twig');
        }


        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setEmail($form->get('email')->getData());


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('user_access/user_profile.html.twig', [
                'user' => $user,
                'form' => $form

            ]);
        }



        return $this->render('user_access/user_profile.html.twig', [
            'user' => $user,
            'form' => $form

        ]);
    }
}
