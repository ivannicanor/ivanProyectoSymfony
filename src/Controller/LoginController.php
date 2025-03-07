<?php

namespace App\Controller;

<<<<<<< Updated upstream
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
=======
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
>>>>>>> Stashed changes
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

<<<<<<< Updated upstream
=======

         // Llamar a CrearLogController para registrar la acción
         $this->forward(CrearLogController::class . '::crearLog', ['accion' => 'Login de usuario']);


        

        

>>>>>>> Stashed changes
        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
<<<<<<< Updated upstream
=======

        

>>>>>>> Stashed changes
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        
    }

}
