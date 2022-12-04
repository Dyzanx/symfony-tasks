<?php

namespace App\form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label' => 'Title'
        ])->add('priority', ChoiceType::class, [
            'label' => 'Priority',
            'choices' => [
                'high' => 'high',
                'medium' => 'medium',
                'low' => 'low'
            ]
        ])->add('content', TextareaType::class, [
            'label' => 'Content'
        ])->add('hours', TextType::class, [
            'label' => 'Presupuested hours'
        ])->add('submit', SubmitType::class, [
            'label' => 'Save'
        ]);
    }
}
