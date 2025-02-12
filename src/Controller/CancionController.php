<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
        $estilo = new Estilo();
        $estilo->setNombre('Pop');
        $estilo->setDescripcion('Estilo musical orientado al pop moderno.');
        $entityManager->persist($estilo);

        $cancion = new Cancion();
        $cancion->setTitulo('Cancion de Prueba');
        $cancion->setDuracion(210);
        $cancion->setAlbum('Album de Prueba');
        $cancion->setAutor('Autor Prueba');
        $cancion->setLikes(200);
        $cancion->setGenero($estilo);

        $entityManager->persist($cancion);
        $entityManager->flush();

        return new Response('Cancion creada con ID: ' . $cancion->getId());
    }




    #[Route('/cancion/{songName}/play', name: 'play_music', methods: ['GET'])]
    public function playMusic(string $songName): Response
    {
        $musicDirectory = $this->getParameter('kernel.project_dir') . '/songs/';
        $filePath = $musicDirectory . $songName;
        if (!file_exists($filePath)) {
            return new Response('Archivo no encontrado', 404);
        }
        return new BinaryFileResponse($filePath);
    }

    #[Route('/music', name: 'app_music')]
    public function indexMusic(): Response
    {
        

        return $this->render('play/play.html.twig', [
            
        ]);
    }
}
