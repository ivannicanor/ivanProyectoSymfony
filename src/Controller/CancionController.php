<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }

    #[Route('/cancion/new', name: 'cancion_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $estilo = $entityManager->getRepository(Estilo::class)->find(1); // Obtener un estilo existente

        $cancion = new Cancion();
        $cancion->setTitulo('Canción Prueba');
        $cancion->setDuracion(180);
        $cancion->setAlbum('Álbum Prueba');
        $cancion->setAutor('Autor Prueba');
        $cancion->setGenero($estilo);
        $cancion->setReproducciones(500);
        $cancion->setLikes(50);

        $entityManager->persist($cancion);
        $entityManager->flush();

        return new Response('Canción creada con éxito');
    }
}
