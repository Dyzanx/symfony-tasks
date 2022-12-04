<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Task;
use App\form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Regex;

class TaskController extends AbstractController
{
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $taskRep = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $taskRep->findBy([], ['id' => 'DESC']);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function detail(Task $task)
    {
        if (!$task) {
            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }

    public function creation(Request $req, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task', ['id' => $task->getId()])
            );
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function myTasks(UserInterface $user)
    {
        $tasks = $user->getTasks();
        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function edit(Request $req, UserInterface $user, Task $task)
    {
        if (!$user || !$user->getId() != $task->getUser()->getId()) {
            $this->redirectToRoute('tasks');
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task', ['id' => $task->getId()])
            );
        }

        return $this->render('task/create.html.twig', [
            'edit' => true,
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    public function delete(UserInterface $user, Task $task)
    {
        if (!$user || $user->getId() != $task->getUser()->getId()) {
            $this->redirectToRoute('tasks');
        }

        if (!$task) {
            $this->redirectToRoute('tasks');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('tasks');
    }
}
