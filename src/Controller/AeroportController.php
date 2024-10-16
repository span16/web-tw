<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Form\AeroportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AeroportController extends AbstractController
{
    #[Route('/aeroport', name: 'app_aeroport')]
    public function index(): Response
    {
        return $this->render('aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
        ]);
    }
    #[Route('/aeroports', name: 'app_aeroport_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $aeroports = $entityManager->getRepository(Aeroport::class)->findAll();

        return $this->render('aeroport/index.html.twig', [
            'aeroports' => $aeroports,
        ]);
    }
    #[Route('/aeroport/new', name: 'app_aeroport_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType ::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aeroport);
            $entityManager->flush();

            return $this->redirectToRoute('app_aeroport_list');
        }

        return $this->render('aeroport/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
  #[Route('/aeroport/{id}/edit', name: 'app_aeroport_edit')]
    public function edit(Aeroport $aeroport, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_aeroport_list');
        }

        return $this->render('aeroport/updatea.html.twig', [
            'form' => $form->createView(),
            'aeroport' => $aeroport
        ]);
    }
}
