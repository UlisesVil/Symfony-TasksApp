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

class TaskController extends AbstractController{
    
    public function index(){

        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([],['id'=>'DESC']);
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
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
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
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
        $task->setEndedAt(new \DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em -> persist($task);
        $em ->flush();
        return $this->redirectToRoute('my_tasks');
    }
    
    public function comment(Request $request, UserInterface $user, Task $task){
        $form = $this->createForm(CommentType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            return $this->redirect($this->generateUrl('my_tasks',['id' => $task->getId()]));
        }
        $tasks = $user->getTasks();   
        return $this->render('task/comment-task.html.twig',[
            'form' => $form->createView(),
            'tasks' => $tasks,
            'task' => $task
        ]);
    }
    
    public function editComment(Request $request, UserInterface $user, Task $task){
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }         
        $form = $this->createForm(CommentType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            return $this->redirect($this->generateUrl('my_tasks',['id' => $task->getId()]));
        }
        $tasks = $user->getTasks();
        return $this->render('task/comment-task.html.twig',[
            'edit' => true,
            'form' => $form->createView(),
            'tasks' => $tasks,
            'task' => $task,
        ]);
    }
    
    
    public function commentTask(Request $request, UserInterface $user, Task $task){
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }      
        $form = $this->createForm(CommentType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($task);
            $em ->flush();
            return $this->redirect($this->generateUrl('my_tasks',['id' => $task->getId()]));
        }
        $tasks = $user->getTasks();
        return $this->render('task/comment-task.html.twig',[
            'edit' => true,
            'form' => $form->createView(),
            'tasks' => $tasks,
            'task' => $task
        ]);
    }
}
