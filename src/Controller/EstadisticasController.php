<?php

namespace App\Controller;

use App\Repository\CancionRepository;
use App\Repository\PlaylistCancionRepository;
use App\Repository\PlaylistRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstadisticasController extends AbstractController
{
    #[Route('/manager/estadisticas', name: 'estadisticas')]
    public function index(PlaylistCancionRepository $playlistCancionRepository): Response
    {
        // Obtener datos de reproducciones por playlist
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->render('estadisticas/index.html.twig', [
            'datos' => $datos
        ]);
    }

    #[Route('/estadisticas/datosReproducciones', name: 'estadisticas_datosReproducciones')]
    public function obtenerDatosReproducciones(PlaylistCancionRepository $playlistCancionRepository): JsonResponse
    {
        $datosReproducciones = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();

        return $this->json($datosReproducciones); // convierte el array $datos en una respuesta JSON.
    }

    #[Route('/estadisticas/datosLikes', name: 'estadisticas_datosLikes')]
    public function obtenerDatosLikes(PlaylistRepository $PlaylistRepository): JsonResponse
    {
        $datosLikes = $PlaylistRepository->obtenerLikesPorPlaylist();

        return $this->json($datosLikes); // convierte el array $datos en una respuesta JSON.
    }

<<<<<<< Updated upstream
=======
<<<<<<< HEAD
    //edades
    #[Route('/estadisticas/datosEdades', name: 'estadisticas_datosEdades')]
    public function obtenerDatosEdades(UsuarioRepository $UsuarioRepository): JsonResponse
    {
        // Obtener los datos de fecha de nacimiento y cantidad de usuarios con esa fecha
    $datos = $UsuarioRepository->obtenerEdadesPorUsuario();
    
    // Array para agrupar las edades y su respectiva cantidad de usuarios
    $edadesAgrupadas = [];

    foreach ($datos as $dato) {
        // Verificar que la fecha de nacimiento sea un objeto DateTime
        if ($dato['fechaNacimiento'] instanceof \DateTime) {
            // Calcular la edad restando la fecha de nacimiento a la fecha actual
            $edad = (new \DateTime())->diff($dato['fechaNacimiento'])->y;

            // Si la edad aún no está en el array, inicializarla en 0
            if (!isset($edadesAgrupadas[$edad])) {
                $edadesAgrupadas[$edad] = 0;
            }

            // Sumar el número de usuarios que tienen esta edad
            $edadesAgrupadas[$edad] += $dato['numeroConEsaEdad'];
        }
    }

    // Formatear los datos en un array adecuado para la respuesta JSON
    $resultado = [];
    foreach ($edadesAgrupadas as $edad => $cantidad) {
        $resultado[] = ['edad' => $edad, 'numeroConEsaEdad' => $cantidad];
    }

    // Retornar los datos en formato JSON
    return $this->json($resultado);
}

    #[Route('/estadisticas/datosCancionReproduccion', name: 'estadisticas_datosCancionReproduccion')]
    public function obtenerCancionesMasReproducidas(CancionRepository $CancionRepository): JsonResponse
    {
        $datosCancionReproduccion = $CancionRepository->obtenerCancionesMasReproducidas();

        return $this->json($datosCancionReproduccion); // convierte el array $datos en una respuesta JSON.
    }
    

=======
>>>>>>> Stashed changes
    #[Route('/estadisticas/datosEdades', name: 'estadisticas_datosEdades')]
    public function obtenerDatosEdades(UsuarioRepository $UsuarioRepository): JsonResponse
    {
        $datosEdades = $UsuarioRepository->obtenerEdadesPorUsuario();

        //calcular edad en numero en vez de en un dateTime
        foreach ($datosEdades as &$usuario) {
            if (isset($usuario['edades']) && $usuario['edades'] instanceof \DateTime) {
                $fechaNacimiento = $usuario['edades']; // Ya es un objeto DateTime
                $hoy = new \DateTime();
                $edad = $hoy->diff($fechaNacimiento)->y; // Calcula la edad en años
                $usuario['edades'] = $edad; // Reemplaza la fecha de nacimiento con la edad calculada
            }
        }

        return $this->json($datosEdades); // convierte el array $datos en una respuesta JSON.
    }

<<<<<<< Updated upstream
=======
>>>>>>> 931bc20cef17cbd0647ed97f347b8f52c12b9395
>>>>>>> Stashed changes
    #[Route('/estadisticas/datosEstiloReproducciones', name: 'estadisticas_datosEstiloReproducciones')]
    public function obtenerDatosEstiloReproducciones(CancionRepository $CancionRepository): JsonResponse
    {
        $datosEstiloReproduccion = $CancionRepository->obtenerReproduccionesPorEstilo();

        return $this->json($datosEstiloReproduccion); // convierte el array $datos en una respuesta JSON.
    }

<<<<<<< Updated upstream
=======
<<<<<<< HEAD

    

=======
>>>>>>> 931bc20cef17cbd0647ed97f347b8f52c12b9395
>>>>>>> Stashed changes
}
