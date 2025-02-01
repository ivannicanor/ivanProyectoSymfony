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
        $usuario = new Usuario();
        $usuario->setEmail('usuario_playlist@example.com');
        $usuario->setPassword('password789');
        $usuario->setNombre('Usuario Playlist 2');
        $usuario->setFechaNacimiento(new \DateTime('1992-10-10'));
        $entityManager->persist($usuario);

        $playlist = new Playlist();
        $playlist->setNombre('Playlist del Usuario');
        $playlist->setVisibilidad('privada');
        $playlist->setReproducciones(30);
        $playlist->setLikes(15);
        $playlist->setUsuarioPropietario($usuario);
        $entityManager->persist($playlist);

        $usuarioPlaylist = new UsuarioPlaylist();
        $usuarioPlaylist->setReproducida(5);
        $usuarioPlaylist->setUsuario($usuario);
        $usuarioPlaylist->setPlaylist($playlist);
        
        $entityManager->persist($usuarioPlaylist);
        $entityManager->flush();

        return new Response('UsuarioPlaylist creada con ID: ' . $usuarioPlaylist->getId());
    }
}
