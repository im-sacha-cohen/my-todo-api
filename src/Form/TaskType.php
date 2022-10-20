<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la tâche *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Liste de courses'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de la tâche *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Acheter du pain, carottes et sel.'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            //->add('author') ===> must be the user authenticated
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
