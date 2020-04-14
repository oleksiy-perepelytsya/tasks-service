<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{

    /**
     * @Route("/task/user/{userId}", methods={"GET"})
     * @param string $userId
     * @return string
     */
    public function listTasksForUser($userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tasks = $entityManager->getRepository(Task::class)->findBy(['userId' => $userId, 'status' => Task::STATUS_NEW], ['timestamp' => 'DESC']);

        if(!$tasks){
            return $this->json(['status' => Response::HTTP_NOT_FOUND ]);
        }

        $result = [];
        foreach ($tasks as $task) {
            $result[] = $task->toArray();
        }

        return $this->json(['status' => Response::HTTP_OK, 'resource' => $result]);

    }
    /**
     * @Route("/task/add/user/{userId}", methods={"POST"}))
     * @param string $userId
     * @return string
     */
    public function addNewTask($userId)
    {
        $request = Request::createFromGlobals();
        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task();
        $task->setUserId($userId);
        $task->setText(trim($request->request->get('text')));
        $task->setStatus(Task::STATUS_NEW);
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->json(['status' => Response::HTTP_OK, 'id' => $task->getId()]);
    }

    /**
     * @Route("/task/completed/user/{userId}", methods={"GET"}))
     * @param string $userId
     * @return string
     */
    public function setTaskComplete($userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['userId' => $userId, 'status' => Task::STATUS_NEW], ['timestamp' => 'ASC']);

        if(!$task){
            return $this->json(['status' => Response::HTTP_NOT_FOUND ]);
        }

        $task->setStatus(Task::STATUS_COMPLETED);
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->json(['status' => Response::HTTP_OK]);
    }

}
