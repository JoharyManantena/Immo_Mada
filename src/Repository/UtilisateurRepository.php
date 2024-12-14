<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function loginAdmin(string $pseudo, string $mdp): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->join('u.type', 't')
            ->where('t.id = :typeId')
            ->andWhere('u.pseudo = :pseudo')
            ->andWhere('u.mdp = :mdp')
            ->setParameter('typeId', 1)
            ->setParameter('pseudo', $pseudo)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function loginProprietaire(string $telephone): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->join('u.type', 't')
            ->where('t.id = :typeId')
            ->andWhere('u.telephone = :telephone')
            ->setParameter('typeId', 2)
            ->setParameter('telephone', $telephone)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loginClient(string $email): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->join('u.type', 't')
            ->where('t.id = :typeId')
            ->andWhere('u.email = :email')
            ->setParameter('typeId', 3)
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
