<?php

namespace App\Controller\Admin;

use App\Controller\CrearLogController;
use App\Entity\Estilo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EstiloCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Estilo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Llamar a CrearLogController para registrar la acción
        $this->forward(CrearLogController::class . '::crearLog', ['accion' => 'Crear Estilo']);

        return [
            IdField::new('id')->hideOnForm(),                  
            TextField::new('nombre', 'Nombre del estilo'),  
            TextareaField::new('descripcion', 'Descripción'),  

        ];
    }
}
