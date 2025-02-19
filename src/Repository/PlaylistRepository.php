<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function obtenerLikesPorPlaylist(): array
    {
        return $this->createQueryBuilder('p') // 'p' es el alias de la entidad de la tabla de playlists
            ->select('p.nombre AS playlist, p.likes AS totalLikes')
            ->getQuery()
            ->getResult();
    }
}
