<?php

namespace App\Controller;

use App\Repository\AnswersRepository;
use App\Repository\QuestionsRepository;
use App\Repository\UserRepository;
use App\Service\PdfExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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


    #[Route('/inactiveuser', name: 'app_inactiveuser')]
    public function inactiveUser(UserRepository $userRepository): Response
    {        //find all inactive users:
        $inactiveUser = $userRepository->findInactiveUsers();


        return $this->render('static/inactiveuser.html.twig', [
            'controller_name' => 'StaticController',
            'inactiveUser' => $inactiveUser
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(UserRepository $userRepository, QuestionsRepository $questionsRepository, AnswersRepository $answersRepository): Response
    {
        // find best questions incl. user details
        $bestUserQuestion = $userRepository->findbestQuestion();

        // find best answer incl. user details
        $bestUserAnswer = $userRepository->findBestAnswer();

        // find  user that posted the best (most postive votes) questions
        $bestUser = $userRepository->findUserVotes();


        // # of total questions
        $questionCount = $questionsRepository->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // # of total answers
        $answerCount = $answersRepository->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // # of total users
        $userCount = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();





        return $this->render('static/admin.html.twig', [
            'controller_name' => 'StaticController',
            'bestUserQuestion' => $bestUserQuestion,
            'questionCount' =>   $questionCount,
            'answerCount' =>   $answerCount,
            'userCount' =>   $userCount,
            'bestUserAnswer' => $bestUserAnswer,
            'bestUser' => $bestUser,

        ]);
    }
    public function exportToPdf(PdfExportService $pdfExportService, QuestionsRepository $questionsRepository, AnswersRepository $answersRepository, UserRepository $userRepository)
    {
        // # of total questions
        $questionCount = $questionsRepository->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->getQuery()
            ->getSingleScalarResult();


        // # of total answers
        $answerCount = $answersRepository->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // # of total users
        $userCount = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // find best questions incl. user details
        $bestUserQuestion = $userRepository->findbestQuestion();


        // find best answer incl. user details
        $bestUserAnswer = $userRepository->findBestAnswer();

        // find  user that posted the best (most postive votes) questions
        $bestUser = $userRepository->findUserVotes();





        $data = ['questionCount' => $questionCount, 'answerCount' => $answerCount, 'userCount' => $userCount, 'bestUserQuestion' => $bestUserQuestion, 'bestUserAnswer' => $bestUserAnswer, 'bestUser' => $bestUser];
        $pdfFile = $pdfExportService->exportToPdf($data);

        // Rückgabe der PDF-Datei als Antwort
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="output.pdf"');
        $response->setContent(file_get_contents($pdfFile));

        return $response;
    }
}
