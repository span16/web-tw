<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service', defaults:['name' => null])]
    public function index($name): Response
    {
        return $this->render('service/showservice.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/gotoindex', name:'app_go',)]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_service');
         
    }

}

