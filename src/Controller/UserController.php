<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;   //Modelo/Entidad
use App\Form\RegisterType; //Usar Formulario
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; //accede al encoder 
//para la Password en la ruta config/packages/security.yaml
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //Crear Formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        
        //Rellenar el objeto con los datos del formulario
        $form->handleRequest($request); //Vicular Formulario con el objeto
            
        //Validar el Formulario y Comprobar si ha sido enviado
        //para $form->isValid() tambien aplicamos validacion en la entidad/Modelo de usuario
        if($form->isSubmitted() && $form->isValid()){ 
            //Modificar objeto para guardarlo
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \Datetime('now'));
            
            //Cifrar la contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            //var_dump($user);
            
            //Guardar Usuario
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($user);
            $em->flush();
            
            
            
            return $this->redirectToRoute('tasks');
        } 
        
        
           
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();
          
        return $this->render('user/login.html.twig', array(
           'error' => $error,
            'last_username' => $lastUsername
        ));
    }
    
}
