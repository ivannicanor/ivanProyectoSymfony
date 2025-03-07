<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Playlist;
use App\Entity\PlaylistCancion;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

//crear controlador playlist y cancion


    #[Route('/playlist/añadircancion/{playlistid}', name: 'playlist_añadircancion')]
    public function añadirCancionPlaylist(Request $request, EntityManagerInterface $entityManager,int $playlistid): JsonResponse
    {
        // Obtener los datos enviados desde el fetch
        $data = json_decode($request->getContent(), true);
        $cancionId = $data['cancionId'] ?? null;

        if (!$cancionId) {
            return new JsonResponse(['error' => 'Parametro incorrecto'], Response::HTTP_BAD_REQUEST);
        }

        // Buscar la playlist en la base de datos
        $playlist = $entityManager->getRepository(Playlist::class)->find($playlistid);

        // Buscar las canciones y agregarlas a la playlist
        $cancionRepository = $entityManager->getRepository(Cancion::class);

        // Buscar la cancion en la base de datos
        $cancion = $cancionRepository->find($cancionId);
        if ($cancion) {
            // Crear una nueva relación PlaylistCancion
            $playlistCancion = new PlaylistCancion();
            $playlistCancion->setPlaylist($playlist);
            $playlistCancion->setCancion($cancion);
            // Guardar en la base de datos
            $entityManager->persist($playlistCancion);
        }

        // Guardar todos los cambios en la base de datos
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Cancion añadida correctamente']);
    }



    #[Route('/playlist/crearPlaylist', name: 'playlist_crearPlaylist', methods: ['POST'])]
    public function añadirPlaylist(Request $request,EntityManagerInterface $entityManager,SessionInterface $session): JsonResponse
    {
       

       
        //OBTENER LA SESSION
        //si usuario no se ha logead
            $usuario = $session->get('usuario');
            if ($usuario == null) {
                return new JsonResponse(['error' => 'error usuario'], Response::HTTP_BAD_REQUEST);
            }
        // Obtener los datos enviados desde el fetch
        $data = json_decode($request->getContent(), true);
        $cancionNombre = $data['nombrePlaylist'];
        $likesPlaylist = $data['likesPlaylist'];

        if (!$cancionNombre) {
            return new JsonResponse(['error' => 'Parametro incorrecto'], Response::HTTP_BAD_REQUEST);
        }
        if (!$likesPlaylist) {
            return new JsonResponse(['error' => 'Parametro incorrecto'], Response::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(Usuario::class)->findOneBy(["email"=>$usuario->getEmail()]);

        


        $playlist = new Playlist();
        $playlist->setNombre($cancionNombre);
        $playlist->setVisibilidad('privada');
        $playlist->setLikes($likesPlaylist);
        $playlist->setUsuarioPropietario($user);
        
        $entityManager->persist($playlist);
        $entityManager->flush();

        // Llamar a CrearLogController para registrar la acción
        $this->forward(CrearLogController::class . '::crearLog', ['accion' => 'Crear mi Playlist']);

        return new JsonResponse(['success' => true, 
                                 'message' => 'Playlist añadida correctamente',
                                ]);
    }

}