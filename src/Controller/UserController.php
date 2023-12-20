<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\AnswersRepository;
use App\Repository\QuestionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader2;

#[Route('/user_admin')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user_admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader2 $fileUploader2): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader2->upload($picture);
            } else {
                $pictureName = "default.jpeg";
            }
            $user->setPicture($pictureName);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/q_dashboard', name: 'app_user_dashquestion', methods: ['GET'])]
    public function dashquestion(AnswersRepository $answersRepository, QuestionsRepository $questionsRepository,): Response
    {
        // get an array with every question (Id) with the corresponding tag title 
        $tagQuestionArray = [];
        $allQuestions = $questionsRepository->findAll();
        foreach ($allQuestions as $question) {
            $questionsTags = $questionsRepository->find($question->getId())->getTags();
            for ($i = 0; $i < count($questionsTags); $i++) {
                $questionId = $question->getId();
                $tagTitle = $questionsRepository->find($question->getId())->getTags()[$i]->getTitle();
                $tagQuestionArray[] = ["questionid" => $questionId, 'tagTitle' => $tagTitle];
            }
        }

        return $this->render('user_admin/q_dashboard.html.twig', [
            'questions' => $questionsRepository->findAll(),
            'tagQuestionArray' => $tagQuestionArray,
        ]);
    }





    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user_admin/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, FileUploader2 $fileUploader2): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                if ($user->getPicture() != "default.jpeg") {
                    unlink($this->getParameter("picture_directory") . "/" . $user->getPicture());
                }
                $pictureName = $fileUploader2->upload($picture);
                $user->setPicture($pictureName);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route("/user/{id}/ban", name: 'app_user_ban', methods: ['GET', 'POST'])]
    public function banUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setIsBanned(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index');
    }

    #[Route("/user/{id}/unban", name: 'app_user_unban', methods: ['GET', 'POST'])]
    public function unbanUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setIsBanned(false);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index');
    }

    #[Route("/user/{id}/ban48hours", name: 'app_user_ban_48_hours', methods: ['GET', 'POST'])]
    public function banUserFor48Hours(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setIsBanned(true);

        $TimedBan = new \DateTime('+48 hours');
        $user->setTimedBan($TimedBan);

        $entityManager->flush();

        return $this->redirectToRoute('app_user_index');
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            if ($user->getPicture() != "default.jpeg") {
                unlink($this->getParameter("picture_directory") . "/" . $user->getPicture());
            }
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
