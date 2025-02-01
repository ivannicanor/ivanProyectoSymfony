<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Playlist;
use App\Entity\PlaylistCancion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistCancionController extends AbstractController
{
    #[Route('/playlist/cancion', name: 'app_playlist_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistCancionController.php',
        ]);
    }
    #[Route('/playlistcancion/new', name: 'playlistcancion_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();
        $playlist->setNombre('Playlist Asociada');
        $playlist->setVisibilidad('privada');
        $playlist->setReproducciones(20);
        $playlist->setLikes(10);
        $entityManager->persist($playlist);

        $cancion = new Cancion();
        $cancion->setTitulo('Cancion Asociada');
        $cancion->setDuracion(180);
        $cancion->setAlbum('Album Asociado');
        $cancion->setAutor('Autor Asociado');
        $cancion->setReproducciones(30);
        $cancion->setLikes(200);
        $entityManager->persist($cancion);

        $playlistCancion = new PlaylistCancion();
        $playlistCancion->setPlaylist($playlist);
        $playlistCancion->setCancion($cancion);
        
        $entityManager->persist($playlistCancion);
        $entityManager->flush();

        return new Response('PlaylistCancion creada con ID: ' . $playlistCancion->getId());
    }

}
