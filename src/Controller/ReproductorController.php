<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReproductorController extends AbstractController
{
    #[Route('/reproductor', name: 'reproductor_play', methods: ['GET'])]
    public function play(EntityManagerInterface $entityManager): Response
    {

        // Obtener todas las canciones
        $songs = $entityManager->getRepository(Cancion::class)->findAll();

        $songData = [];

        $musicDirectory = '/songs/';
        $imageDirectory = '/images/';

        
        foreach ($songs as $song) {
            $songData[] = [
                'name' =>$song->getTitulo(),
                'imagen' =>$imageDirectory . $song->getImagen(),
                'audio' =>$musicDirectory . $song->getArchivo(),
            ];
        }

       // Obtener todas las playlist
       $playlists = $entityManager->getRepository(Playlist::class)->findAll();

       $playlistData = [];

       
       $imageDirectory = '/images/';

       
       foreach ($playlists as $playlist) {
           $playlistData[] = [
               'nombre' =>$playlist->getNombre(),
               'imagen' =>$imageDirectory . 'c1.jpg',
               'id' =>$playlist->getId(),
               'likes' =>$playlist->getLikes(),
           ];
       }
       return $this->render('reproductor/play.html.twig', [
           'songs' => $songData,
           'playlists' => $playlistData,
       ]); 
   }




}
