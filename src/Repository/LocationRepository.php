<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function calculateMonthlyRevenue(): array
    {
        $entityManager = $this->getEntityManager();

        $locations = $entityManager->getRepository(Location::class)
            ->createQueryBuilder('l')
            ->leftJoin('l.bien', 'b')
            ->leftJoin('b.type', 'tb')
            ->where('l.dateDebut BETWEEN :start AND :end')
            ->setParameter('start', new \DateTime('2024-01-01'))
            ->setParameter('end', new \DateTime('2024-12-31'))
            ->getQuery()
            ->getResult();

        $results = [];
        foreach ($locations as $location) {
            
            $month = $location->getDateDebut()->format('Y-m');

            if (!isset($results[$month])) {
                $results[$month] = [
                    'chiffre_affaires' => 0,
                    'gains' => 0,
                ];
            }

            $results[$month]['chiffre_affaires'] += $location->getChiffreAffaires();
            $results[$month]['gains'] += $location->getGains();
        }

        ksort($results); // Tri par mois (du plus ancien au plus récent)
        return $results;
    }


    public function calculerChiffreAffairesTotal(\DateTimeImmutable $dateDebut, \DateTimeImmutable $dateFin): float
    {
        $qb = $this->createQueryBuilder('l')
            ->innerJoin('l.bien', 'b')
            ->andWhere('l.dateDebut BETWEEN :dateDebut AND :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->select('SUM(b.loyer * l.duree) AS totalChiffreAffaires');

        $result = $qb->getQuery()->getSingleResult();
        return (float) $result['totalChiffreAffaires'];
    }

    public function findLocationsBetweenDates(\DateTimeImmutable $dateDebut, \DateTimeImmutable $dateFin)
    {
        $qb = $this->createQueryBuilder('l')
            ->innerJoin('l.bien', 'b')
            ->innerJoin('l.client', 'c')
            ->addSelect('b', 'c')
            ->where('l.dateDebut BETWEEN :dateDebut AND :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->orderBy('l.dateDebut', 'ASC');

        $locations = $qb->getQuery()->getResult();

        foreach ($locations as $location) {
            $location->montantTotal = $location->getMontantTotal();
        }

        return $locations;
    }
}
