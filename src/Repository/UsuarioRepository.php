<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Usuario>
 */
class UsuarioRepository extends ServiceEntityRepository implements UserLoaderInterface

{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }


    public function loadUserByIdentifier(string $identifier): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :identifier OR u.username =:identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    //estadistica edades

    public function obtenerEdadesPorUsuario(): array
<<<<<<< Updated upstream
    {
        return $this->createQueryBuilder('u') // 'u' es el alias de la entidad de la tabla de usuario
            ->select('u.fechaNacimiento AS edades,COUNT(u.fechaNacimiento) AS numeroConEsaEdad')
            ->groupBy('edades')
            ->getQuery()
            ->getResult();
    }
=======
{
    return $this->createQueryBuilder('u')
        ->select('u.fechaNacimiento', 'COUNT(u.id) AS numeroConEsaEdad')
        ->groupBy('u.fechaNacimiento')
        ->getQuery()
        ->getResult();
}

>>>>>>> Stashed changes
}
