<?php

namespace App\Form;

use App\Entity\Questions;
use App\Entity\Tags;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            // ->add('created_at')
            ->add('text')
            ->add('image')
            ->add('isChecked')
            ->add('tags', EntityType::class, [
                'class' => Tags::class,
                'choice_label' => 'title',
                'multiple' => true,
                'mapped' => false
            ])
            //             ->add('fk_id_user', EntityType::class, [
            //                 'class' => user::class,
            // 'choice_label' => 'id',
            //             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
