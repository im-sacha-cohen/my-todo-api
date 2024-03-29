<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(date_create())
                ->setUser($this->getUser())
            ;
            $taskRepository->add($task, true);

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->add($task, true);

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/toggle', name: 'app_task_toggle', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function toggleTaskAction(Task $task, TaskRepository $taskRepository)
    {
        $task->setIsDone(!$task->getIsDone());
        $taskRepository->add($task, true);

        $this->addFlash('success', sprintf('La tâche a bien changé d\état !', $task->getTitle()));

        return $this->redirectToRoute('app_task_index');
    }

    #[Route('/{id}/delete', name: 'app_task_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        $isTaskAnonymous = $task->getUser()->hasRole('ROLE_ANONYMOUS');
        $adminCanDeleteAnonymousTask = $isTaskAnonymous && $this->isGranted('ROLE_ADMIN');
        $taskOwnedByCurrentUser = $task->getUser() === $this->getUser();
        
        // The task should be owned by the user that wrote it
        // And the task should not be owner by an anonymous user
        if (
            !$taskOwnedByCurrentUser &&
            !$adminCanDeleteAnonymousTask
        ) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas le propriétaire.');
        } else if (
            $task->getUser() === $this->getUser() ||
            $adminCanDeleteAnonymousTask
        ) {
            if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
                $taskRepository->remove($task, true);

                $this->addFlash('success', 'La tâche a bien été supprimée.');
            }
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
