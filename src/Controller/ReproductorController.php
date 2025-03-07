<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Playlist;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ReproductorController extends AbstractController
{
    #[Route('/reproductor', name: 'reproductor_play', methods: ['GET'])]
    public function play(EntityManagerInterface $entityManager, Request $request,TokenStorageInterface $tokenStorage,SessionInterface $session): Response
    {

        // Obtener todas las canciones
        $songs = $entityManager->getRepository(Cancion::class)->findAll();

        $songData = [];

        $musicDirectory = '/songs/';
        $imageDirectory = '/images/';


        foreach ($songs as $song) {
            $songData[] = [
                'id' => $song->getId(),
                'name' => $song->getTitulo(),
                'imagen' => $imageDirectory . $song->getImagen(),
                'audio' => $musicDirectory . $song->getArchivo(),
            ];
        }

        // Obtener todas las playlist
        $playlists = $entityManager->getRepository(Playlist::class)->findAll();

        $playlistData = [];


        $imageDirectory = '/images/';


        foreach ($playlists as $playlist) {
            $playlistData[] = [
                'nombre' => $playlist->getNombre(),
                'imagen' => $imageDirectory . 'c1.jpg',
                'id' => $playlist->getId(),
                'likes' => $playlist->getLikes(),
            ];
        }









        //CREAR LA SESSION
         // Obtener el usuario autenticado
         $token = $tokenStorage->getToken();
         $usuario = $token?->getUser(); // obtenemos el usuario

         //transformamos lo que nos devuelve en una Instancia de tipo Usuario
         if ($usuario && !($usuario instanceof Usuario)) {
             // Si Symfony devuelve un string (el email), buscamos el usuario en la base de datos
             $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $usuario]);
         }
     
         // Guardar el email del usuario autenticado en la sesión
         if ($usuario instanceof Usuario) { 
             $session->set('usuario', $usuario); 
         }



        // inicializar session
        $session = $request->getSession();

        //OBTENER LA SESSION
        //si usuario no se ha logeado
        if ( $session->get('usuario')==null) {
            // Obtener el null
            $emailUsuario = $session->get('usuario');
        }else{
        //si usuario se ha logeado
        // Obtener el email del usuario autenticado
            $emailUsuario = $session->get('usuario')->getEmail();
        }
        
        
        
        $playlistsUsuario = [];

        if ($emailUsuario) {
            // Buscar al usuario en la base de datos por su email
            $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $emailUsuario]);
            
            

            if ($usuario) {
                // Obtener las playlists asociadas a este usuario
                $playlistsUsuario = $usuario->getPlaylists();
                
                
            }
        }

        $playlistDataUsuario = [];
        $imageDirectory = '/images/';

        foreach ($playlistsUsuario as $playlistUsuario) {
            $playlistDataUsuario[] = [
                'nombre' => $playlistUsuario->getNombre(),
                'imagen' => $imageDirectory . 'c1.jpg',
                'id' => $playlistUsuario->getId(),
                'likes' => $playlistUsuario->getLikes(),
            ];
        }

        return $this->render('reproductor/play.html.twig', [
            'songs' => $songData,
            'playlists' => $playlistData,
            'playlistsUsuario' => $playlistDataUsuario,
        ]);
    }
}
