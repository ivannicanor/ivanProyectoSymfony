<?php

namespace App\Controller\Admin;

use App\Entity\Cancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cancion::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            //ocultar el id no queremos que salga
            IdField::new('id')->hideOnForm(),
            TextField::new('titulo', 'Título'),              
            IntegerField::new('duracion', 'Duración (s)'),   
            TextField::new('album', 'Álbum'),                
            TextField::new('autor', 'Autor'),               
            IntegerField::new('likes', 'Likes'),
            AssociationField::new('genero', 'Genero')
            ->setFormTypeOption('by_reference', true),             

           
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
