<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'app_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }

    #[Route('/playlist/new', name: 'playlist_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $usuario = $entityManager->getRepository(Usuario::class)->find(1); // Obtener un usuario existente

        $playlist = new Playlist();
        $playlist->setNombre('Mi Playlist');
        $playlist->setVisibilidad('publica');
        $playlist->setPropietario($usuario);
        $playlist->setReproducciones(100);
        $playlist->setLikes(10);

        $entityManager->persist($playlist);
        $entityManager->flush();

        return new Response('Playlist creada con éxito');
    }

}
