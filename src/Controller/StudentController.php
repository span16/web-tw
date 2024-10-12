<?php

namespace App\Controller;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/readstudent',name:'app_student')]
    public function readstudent(StudentRepository $repo):Response
    {$list= $repo->findAll();
        return $this->render('student/student.html.twig',
        ['students'=>$list]);
    }
}
