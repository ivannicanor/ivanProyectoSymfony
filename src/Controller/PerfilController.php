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
        $estilo->setDescripcion('Estilo de música rock');

        $perfil = new Perfil();
        $perfil->setFoto('perfil.jpg');
        $perfil->setDescripcion('Perfil de usuario prueba');
        $perfil->setEstiloMusicalPreferido($estilo);

        $entityManager->persist($estilo);
        $entityManager->persist($perfil);
        $entityManager->flush();

        return new Response('Perfil creado con éxito.');
    }

}
