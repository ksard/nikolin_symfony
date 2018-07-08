<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Projects;

use App\Entity\ProjectTasks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */
    public function index(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $tasksPerProject = [];
        $projects = [];
        $statuses = [];
        $projects = $this->getDoctrine()->getRepository(Projects::class)->findAll();
        $projectsJson = $serializer->serialize($projects, 'json');
        $statuses = ['pending' => 'pending', 'done' => 'done', 'failed' => 'failed'];
        $tasksPerProject = $this->getTasksPerProject();

        $task = new ProjectTasks();
        $form = $this->createFormBuilder($task)
        ->add('deadline', DateTimeType::class, array('label' => 'Kраен срок'))
        ->add('description', TextType::class, array('label' => 'Кратко описание'))
        ->add('status', ChoiceType::class, [
            'choices' => $statuses,
                
        ])
        ->add('projects', ChoiceType::class, [
            'choices' => $projects,
        ])
        ->add('save', SubmitType::class, array('label' => 'Добави'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
    
            return $this->redirect($request->getUri());
        }
        
        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasksPerProject,
            'form' => $form->createView(),
        ]);
    }

    public function getTasksPerProject()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $tasks = $this->getDoctrine()->getRepository(ProjectTasks::class)->findAll();
        $jsonTasks = $serializer->serialize($tasks, 'json');

        return $tasks;
    }
}
