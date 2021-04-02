<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\RegisterType; 
//Usar Formulario


class RegisterType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', TextType::class, array(
            'label' => 'Name'
        ))
        ->add('surname', TextType::class, array(
            'label' => 'Last Name',
        ))
        ->add('email', EmailType::class, array(
            'label' => 'E-mail'
        ))
        ->add('password', PasswordType::class, array(
            'label' => 'Password'
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Sign Up'
        ));
    }
}