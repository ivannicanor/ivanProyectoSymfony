<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'usuarioPropietario')]
    private Collection $playlists;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Perfil $perfil = null;

    /**
     * @var Collection<int, UsuarioListenPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioListenPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuarioListenPlaylists;


    public function __construct()
    {
        $this->playlists = new ArrayCollection();
        $this->usuarioListenPlaylists = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nombre?? 'Sin nombre';
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

     /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setUsuarioPropietario($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getUsuarioPropietario() === $this) {
                $playlist->setUsuarioPropietario(null);
            }
        }

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil): static
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * @return Collection<int, UsuarioListenPlaylist>
     */
    public function getUsuarioListenPlaylists(): Collection
    {
        return $this->usuarioListenPlaylists;
    }

    public function addUsuarioListenPlaylist(UsuarioListenPlaylist $usuarioListenPlaylist): static
    {
        if (!$this->usuarioListenPlaylists->contains($usuarioListenPlaylist)) {
            $this->usuarioListenPlaylists->add($usuarioListenPlaylist);
            $usuarioListenPlaylist->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioListenPlaylist(UsuarioListenPlaylist $usuarioListenPlaylist): static
    {
        if ($this->usuarioListenPlaylists->removeElement($usuarioListenPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioListenPlaylist->getUsuario() === $this) {
                $usuarioListenPlaylist->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
