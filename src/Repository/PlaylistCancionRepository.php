<?php

namespace App\Repository;

use App\Entity\PlaylistCancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlaylistCancion>
 */
class PlaylistCancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistCancion::class);
    }

<<<<<<< Updated upstream
    public function obtenerReproduccionesPorPlaylist(): array
=======
    public function obtenerReproduccionesPorPlaylist(int $limite = 10): array
>>>>>>> Stashed changes
    {
        return $this->createQueryBuilder('pc')
            ->select('p.nombre AS playlist, SUM(pc.reproducciones) AS totalReproducciones')
            ->join('pc.playlist', 'p')
            ->groupBy('p.id')
<<<<<<< Updated upstream
=======
            ->setMaxResults($limite) // Limitar el número de resultados (por defecto 10)
>>>>>>> Stashed changes
            ->getQuery()
            ->getResult();
    }

    
}
