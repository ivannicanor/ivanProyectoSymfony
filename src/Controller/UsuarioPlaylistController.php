<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Entity\UsuarioPlaylist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioPlaylistController extends AbstractController
{
    #[Route('/usuario/playlist', name: 'app_usuario_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioPlaylistController.php',
        ]);
    }


    #[Route('/usuarioplaylist/new', name: 'usuarioplaylist_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $usuario = $entityManager->getRepository(Usuario::class)->find(1); // Obtener un usuario existente
        $playlist = $entityManager->getRepository(Playlist::class)->find(1); // Obtener una playlist existente

        $usuarioPlaylist = new UsuarioPlaylist();
        $usuarioPlaylist->setUsuario($usuario);
        $usuarioPlaylist->setPlaylist($playlist);
        $usuarioPlaylist->setReproducida(10);

        $entityManager->persist($usuarioPlaylist);
        $entityManager->flush();

        return new Response('UsuarioPlaylist creada con éxito.');
    }
}
