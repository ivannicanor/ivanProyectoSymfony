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
        $playlist->setLikes(50);
        $playlist->setUsuarioPropietario($usuario);
        
        $entityManager->persist($playlist);
        $entityManager->flush();

        return new Response('Playlist creada con ID: ' . $playlist->getId());
    }

    #[Route('/playlist/{id}', name: 'playlist_show', methods: ['GET'])]
public function showPlaylist(EntityManagerInterface $entityManager, int $id): Response
{
    // Obtener la playlist por su ID
    $playlists = $entityManager->getRepository(Playlist::class)->find($id);

    
    // Obtener las canciones de la playlist (suponiendo que la entidad tiene una relación con Cancion)
    $songs = $playlists->getPlaylistCancions(); // Si la relación se llama 'canciones'


    $songData = [];

    $musicDirectory = '/songs/';
    $imageDirectory = '/images/';

    
    foreach ($songs as $song) {
        $songData[] = [
            'name' =>$song->getCancion()->getTitulo(),
            'imagen' => $imageDirectory . $song->getCancion()->getImagen(),
            'audio' => $musicDirectory . $song->getCancion()->getArchivo(),

        ];
    }


    return $this->render('reproductor/playlist.html.twig', [
        'playlists' => $playlists,
        'songs' => $songData,
    ]);
}


}
