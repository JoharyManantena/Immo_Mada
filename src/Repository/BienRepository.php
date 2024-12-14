<?php

namespace App\Repository;

use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bien>
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    public function findAllBiensWithDetails()
    {
        return $this->createQueryBuilder('b')
            ->select('b.id AS id_bien', 'b.nom AS nom_bien', 'b.description', 'tb.nom AS type_bien', 'r.nom AS region', 'b.loyer', 'b.photos')
            ->leftJoin('b.type', 'tb')
            ->leftJoin('b.region', 'r')
            ->orderBy('b.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
