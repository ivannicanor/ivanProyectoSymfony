<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $visibilidad = null;

    #[ORM\Column]
    private ?int $likes = null;

    #[ORM\ManyToOne]
    private ?Usuario $usuarioPropietario = null;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getVisibilidad(): ?string
    {
        return $this->visibilidad;
    }

    public function setVisibilidad(string $visibilidad): static
    {
        $this->visibilidad = $visibilidad;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getUsuarioPropietario(): ?Usuario
    {
        return $this->usuarioPropietario;
    }

    public function setUsuarioPropietario(?Usuario $usuarioPropietario): static
    {
        $this->usuarioPropietario = $usuarioPropietario;

        return $this;
    }

   
}
