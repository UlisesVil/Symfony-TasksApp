<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Form\CommentType;
use Symfony\Component\Security\Core\User\UserInterface;


class TaskController extends AbstractController
{
    
    
    public function index()
    {
        //prueba de entidades y relaciones
        $em = $this->getDoctrine()->getManager();
        
        
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([],['id'=>'DESC']);
        
        
        
        
        /*
        $user_repo = $this->getDoctrine()->getRepository(User::class); //Cargamos el modelo User para usar esta clase
        $users = $user_repo->findAll(); //obtenemos todos los usuarios
        
        foreach($users as $user){
            echo "<h1>{$user->getName()} {$user->getSurname()}</h1>";
            
            foreach($user->getTasks() as $task){
            echo $task->getTitle()."<br>";
            }
        }
        */
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }
    
    public function detail(Task $task){
        if(!$task){
            return $this->redirectToRout('tasks');
        }
        
        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }
    
    
    public function creation(Request $request, UserInterface $user){
        //\Symfony\Component\Security\Core\User\UserInterface $user con esto obtengo 
        //el usuario autenticado
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        
        $form->handleRequest($request);  //handleRequest une lo que llega por la peticion al objeto
        
        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            //var_dump($task);
            //die();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            
            return $this->redirect($this->generateUrl('task_detail',['id' => $task->getId()]));
        }
        return $this->render('task/creation.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    
    public function myTasks(UserInterface $user){
        $tasks = $user->getTasks();
        
        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks 
        ]);
    }
    
    
    
    public function edit(Request $request, UserInterface $user, Task $task){
        
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
                    
        $form = $this->createForm(TaskType::class, $task);
        
        $form->handleRequest($request);  //handleRequest une lo que llega por la peticion al objeto
        
        if($form->isSubmitted() && $form->isValid()){
            //$task->setCreatedAt(new \DateTime('now')); la fecha de creacion no se actualizara
            //$task->setUser($user); no quiero actualizar de nuevo el usuario
            
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            
            return $this->redirect($this->generateUrl('task_detail',['id' => $task->getId()]));
        }
        
        return $this->render('task/creation.html.twig',[
            'edit' => true,
            'form' => $form->createView()
        ]);
    }
    
    
    
    public function delete(UserInterface $user, Task $task){
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
        
        if(!$task){
            return $this->redirectToRout('tasks');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em -> remove($task);
        $em ->flush();
        
        return $this->redirectToRoute('my_tasks');
    }
    
    
    
    public function ended(UserInterface $user, Task $task){
        //var_dump($task);
            //die();
        //if(!$user || $user->getId() != $task->getUser()->getId()){
          //  return $this->redirectToRoute('tasks');
        //}
        
        
            $task->setEndedAt(new \DateTime('now'));
            
            
            //var_dump($task);
            //die();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            
            return $this->redirectToRoute('my_tasks');
        
        
    }
    
    public function comment(Request $request, UserInterface $user, Task $task){
        //\Symfony\Component\Security\Core\User\UserInterface $user con esto obtengo 
        //el usuario autenticado
        
       
        $form = $this->createForm(CommentType::class, $task);
        
        $form->handleRequest($request);  //handleRequest une lo que llega por la peticion al objeto
        
        if($form->isSubmitted() && $form->isValid()){
            //var_dump($task);
            //die();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            
            return $this->redirect($this->generateUrl('my_tasks',['id' => $task->getId()]));
        }
        
           $tasks = $user->getTasks();
           
        return $this->render('task/my-tasks.html.twig',[
            'form' => $form->createView(),
             'tasks' => $tasks 
        ]);
    }
    
    public function editComment(Request $request, UserInterface $user, Task $task){
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
                    
        $form = $this->createForm(CommentType::class, $task);
        
        $form->handleRequest($request);  //handleRequest une lo que llega por la peticion al objeto
        
        if($form->isSubmitted() && $form->isValid()){
            //$task->setCreatedAt(new \DateTime('now')); la fecha de creacion no se actualizara
            //$task->setUser($user); no quiero actualizar de nuevo el usuario
            
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            
            return $this->redirect($this->generateUrl('my_tasks',['id' => $task->getId()]));
        }
        $tasks = $user->getTasks();
        return $this->render('task/my-tasks.html.twig',[
            'edit' => true,
            'form' => $form->createView(),
            'tasks' => $tasks,
            
        ]);
    }
}
