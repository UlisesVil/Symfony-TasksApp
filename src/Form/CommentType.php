<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//Usar Formulario


class CommentType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('comment', TextareaType::class, array(
            'label' => 'Comentario'
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Guardar'
        ));
    }
}
