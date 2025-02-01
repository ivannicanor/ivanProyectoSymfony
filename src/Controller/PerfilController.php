<?php

namespace App\Controller;

use App\Entity\Estilo;
use App\Entity\Perfil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

    #[Route('/perfil/new', name: 'perfil_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $estilo = new Estilo();
        $estilo->setNombre('Rock');
        $estilo->setDescripcion('Estilo musical orientado al rock clásico.');
        $entityManager->persist($estilo);

        $perfil = new Perfil();
        $perfil->setFoto('foto_perfil.png');
        $perfil->setDescripcion('Perfil de prueba con preferencias musicales.');
        $perfil->addEstilosMusicalPreferido($estilo);
        
        $entityManager->persist($perfil);
        $entityManager->flush();

        return new Response('Perfil creado con ID: ' . $perfil->getId());
    }

}
