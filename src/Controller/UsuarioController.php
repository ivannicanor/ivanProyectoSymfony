<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }


    #[Route('/usuario/new', name: 'usuario_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $perfil = new Perfil();
        $perfil->setFoto('foto_usuario_prueba.png');
        $perfil->setDescripcion('Perfil de prueba asociado al usuario.');
        $entityManager->persist($perfil);

        $usuario = new Usuario();
        $usuario->setEmail('usuario_prueba@example.com');
        $usuario->setPassword('password123');
        $usuario->setNombre('Usuario Prueba');
        $usuario->setFechaNacimiento(new \DateTime('1990-01-01'));
        $usuario->setPerfil($perfil);
        
        $entityManager->persist($usuario);
        $entityManager->flush();

        return new Response('Usuario creado con ID: ' . $usuario->getId());
    }

}
