<?php

namespace App\Controller\Admin;

use App\Entity\Playlist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlaylistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Playlist::class;
    }

    public function configureFields(string $pageName): iterable
    {
       return [
            //ocultar el id no queremos que salga
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre', 'Nombre'),                              
            TextField::new('visibilidad', 'Visibilidad'),               
            IntegerField::new('likes', 'Likes'),
            AssociationField::new('usuarioPropietario', 'Usuario')
            ->setFormTypeOption('by_reference', true),
            CollectionField::new('playlistCancions','canciones')
            ->useEntryCrudForm(PlaylistCancionCrudController::class),         
        ];
    }
}
