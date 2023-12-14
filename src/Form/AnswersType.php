<?php

namespace App\Form;

use App\Entity\Answers;
use App\Entity\Questions;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('created_at')
            ->add('text')
            ->add('fk_id_user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            //             ->add('fk_id_questions', EntityType::class, [
            //                 'class' => Questions::class,
            // 'choice_label' => 'id',
            //             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answers::class,
        ]);
    }
}
