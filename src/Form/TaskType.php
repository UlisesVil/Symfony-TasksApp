<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;//para campo select
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\form\RegisterType; 
//Usar Formulario


class TaskType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('title', TextType::class, array(
            'label' => 'Titulo'
        ))
        ->add('content', TextareaType::class, array(
            'label' => 'Contenido',
        ))
        ->add('priority', ChoiceType::class, array(
            'label' => 'Prioridad',
            'choices' => array(
                'Alta' => 'high',
                'Media' => 'medium',
                'Baja' => 'low'
            )
        ))
        ->add('hours', IntegerType::class, array(
            'label' => 'Horas Presupuestadas'
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Guardar Tarea'
        ));
    }
}