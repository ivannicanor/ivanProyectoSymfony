<?php

namespace App\Controller\Admin;

use App\Controller\CrearLogController;
use App\Entity\PlaylistCancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlaylistCancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaylistCancion::class;
    }

    public function configureFields(string $pageName): iterable
    {
       
       return [
            //ocultar el id no queremos que salga
            IdField::new('id')->hideOnForm(),
            AssociationField::new('playlist', 'Playlist')->hideOnForm()
            ->setFormTypeOption('by_reference', true), 
            AssociationField::new('cancion', 'Cancion')
            ->setFormTypeOption('by_reference', true),
            IntegerField::new('reproducciones', 'Reproducciones'),         
        ];
    }

}
