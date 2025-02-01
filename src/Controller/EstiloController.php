<?php

namespace App\Controller;

use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }

    #[Route('/estilo/new', name: 'estilo_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $estilo = new Estilo();
        $estilo->setNombre('Jazz');
        $estilo->setDescripcion('Estilo musical relajado y sofisticado.');
        
        $entityManager->persist($estilo);
        $entityManager->flush();

        return new Response('Estilo creado con ID: ' . $estilo->getId());
    }
}
