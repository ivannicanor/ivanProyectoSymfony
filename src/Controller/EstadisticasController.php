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

    #[Route('/estadisticas/datosEstiloReproducciones', name: 'estadisticas_datosEstiloReproducciones')]
    public function obtenerDatosEstiloReproducciones(CancionRepository $CancionRepository): JsonResponse
    {
        $datosEstiloReproduccion = $CancionRepository->obtenerReproduccionesPorEstilo();

        return $this->json($datosEstiloReproduccion); // convierte el array $datos en una respuesta JSON.
    }

}
