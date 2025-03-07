<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CrearLogController extends AbstractController
{
    #[Route('/crear/log', name: 'app_crear_log')]
    public function index(): Response
    {
        return $this->render('crear_log/index.html.twig', [
            'controller_name' => 'CrearLogController',
        ]);
    }



    #[Route('/crear/log/{accion}', name: 'crear_log')]
    public function crearLog(string $accion,Request $request): Response
    {


         // inicializar session
         $session = $request->getSession();

         //OBTENER LA SESSION
         //si usuario no se ha logeado
         if ( $session->get('usuario')==null) {
             // Obtener el null
             $emailUsuario = "anonimo";
         }else{
         //si usuario se ha logeado
         // Obtener el email del usuario autenticado
             $rolUsuario = $session->get('usuario')->getRoles();
             $emailUsuario = $session->get('usuario')->getEmail();
              
         }

        
            $logFilePath = __DIR__ . '/../../var/log/log.txt';
         
        
      

         //en caso de que no exista lo crea
        if (!file_exists($logFilePath)) {
           file_put_contents($logFilePath,"Log de acciones\n\n");
        }

        // Establecer la zona horaria para que la hora que saque el log sea la correcta
        date_default_timezone_set('Europe/Madrid');
        

       



        //mensaje que saldra en el log sprintf retorna un string
        $mensaje = sprintf("[%s] Usuario %s - Acción: %s\n", date('Y-m-d H:i:s'), $emailUsuario,$accion);

        //rellena el mensaje en el log
       file_put_contents($logFilePath,$mensaje,FILE_APPEND);

        return new Response('Log registrado con éxito.');
    }
}
