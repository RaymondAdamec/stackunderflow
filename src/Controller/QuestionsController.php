<?php

namespace App\Controller;

use App\Entity\Answers;
use App\Entity\Questions;
use App\Entity\RatingsQuestions;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/questions')]
class QuestionsController extends AbstractController
{
    #[Route('/', name: 'app_questions_index', methods: ['GET'])]
    public function index(QuestionsRepository $questionsRepository): Response
    {
        $isBanned = $this->getUser()->getIsBanned();

        if ($isBanned) {
            return $this->render('banned/index.html.twig');
        }
        return $this->render('questions/index.html.twig', [
            'questions' => $questionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_questions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $now = new DateTime();
        $question = new Questions();

        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);
        $question->setCreatedat($now);
        $question->setFkIdUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setGotAnyAnswer(false);
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questions_show', methods: ['GET'])]
    public function show($id, Questions $question, EntityManagerInterface $em): Response
    {

        $answers = $em->getRepository(Answers::class)->findBy(['fk_id_questions' => $question]);

        return $this->render('questions/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_questions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Questions $question, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questions_delete', methods: ['POST'])]
    public function delete(Request $request, Questions $question, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {

            $answers = $entityManager->getRepository(Answers::class)->findBy(array('fk_id_questions' => $question));
            foreach ($answers as $value) {

                $entityManager->remove($value);
                $entityManager->flush();
            }

            $rq = $entityManager->getRepository(RatingsQuestions::class)->findBy(array('fk_id_question' => $question));
            foreach ($rq as $value) {

                $entityManager->remove($value);
                $entityManager->flush();
            }




            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
    }
}
