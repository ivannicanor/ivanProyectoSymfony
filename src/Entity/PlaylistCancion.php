<?php

namespace App\Entity;

use App\Repository\PlaylistCancionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistCancionRepository::class)]
class PlaylistCancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(nullable: true)]
    private ?int $reproducciones = null;

    #[ORM\ManyToOne(inversedBy: 'playlistCancions')]
    private ?Playlist $playlist = null;


    #[ORM\ManyToOne(inversedBy: 'playlistCancions')]
    private ?Cancion $cancion = null;


    public function __toString(): string
    {
        return $this->getCancion()->getTitulo();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    

    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(?int $reproducciones): static
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getCancion(): ?Cancion
    {
        return $this->cancion;
    }

    public function setCancion(?Cancion $cancion): static
    {
        $this->cancion = $cancion;

        return $this;
    }

}
