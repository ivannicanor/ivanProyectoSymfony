<?php

namespace App\Repository;

use App\Entity\Cancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cancion>
 */
class CancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cancion::class);
    }

    public function obtenerReproduccionesPorEstilo(): array
{

    //tabla por cada estilo sus reproduccioens
    return $this->createQueryBuilder('c')
        ->select('e.nombre AS estilo, SUM(pc.reproducciones) AS totalReproducciones')
        ->join('c.genero', 'e') // Relación con Estilo
        ->join('App\Entity\PlaylistCancion', 'pc', 'WITH', 'pc.cancion = c') // Relación con PlaylistCancion
        ->groupBy('e.id')
        ->getQuery()
        ->getResult();
}

}
