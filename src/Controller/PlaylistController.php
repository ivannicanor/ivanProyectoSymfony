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
        $usuario = new Usuario();
        $usuario->setEmail('usuario_playlist@example.com');
        $usuario->setPassword('password456');
        $usuario->setNombre('Usuario Playlist');
        $usuario->setFechaNacimiento(new \DateTime('1985-05-15'));
        $entityManager->persist($usuario);

        $playlist = new Playlist();
        $playlist->setNombre('Playlist de Prueba');
        $playlist->setVisibilidad('publica');
        $playlist->setReproducciones(100);
        $playlist->setLikes(50);
        $playlist->setUsuarioPropietario($usuario);
        
        $entityManager->persist($playlist);
        $entityManager->flush();

        return new Response('Playlist creada con ID: ' . $playlist->getId());
    }

}
