<?php

namespace App\Command;

use App\Entity\Questions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteInactiveQuestionsCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('app:delete-inactive-questions')
            ->setDescription('Deletes inactive questions older than 48 hours.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->entityManager->getRepository(Questions::class);

        $inactiveQuestions = $repository->findInactiveQuestions(48); // Implement your custom repository method

        foreach ($inactiveQuestions as $question) {
            $this->entityManager->remove($question);
        }

        $this->entityManager->flush();

        $output->writeln('Inactive questions deleted successfully.');

        return Command::SUCCESS;
    }
}
