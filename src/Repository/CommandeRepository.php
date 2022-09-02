<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function add(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function selectMaxId()
    {
        $qb = $this->createQueryBuilder("c");


        return $qb->select('max(c.id)')->getFirstResult();

    }

    public function cmdConfirmee($dateDebut, $dateFin)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        $qb->join('c.status','s');
        $qb->where('s.id=5');
        if ($dateDebut and $dateFin) {
            $qb->andWhere('c.dateCommande between :dateDebut and :dateFin');
            $qb->setParameter('dateDebut', $dateDebut);
            $qb->setParameter('dateFin', $dateFin);
        }

        return $qb->getQuery()->getSingleResult()["count"];

    }
    public function cmdConfirmedByDate($dateDebut, $dateFin)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('c');
        $qb->join('c.status','s');
        $qb->where('s.id=5');
        if ($dateDebut and $dateFin) {
            $qb->andWhere('c.dateCommande between :dateDebut and :dateFin');
            $qb->setParameter('dateDebut', $dateDebut);
            $qb->setParameter('dateFin', $dateFin);
        }

        return $qb->getQuery()->getResult();

    }

    public function nbrCmds($dateDebut, $dateFin)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        if ($dateDebut and $dateFin) {
            $qb->andWhere('c.dateCommande between :dateDebut and :dateFin');
            $qb->setParameter('dateDebut', $dateDebut);
            $qb->setParameter('dateFin', $dateFin);
        }

        return $qb->getQuery()->getSingleResult()["count"];

    }

    public function cmdAnnulee($dateDebut, $dateFin)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        $qb->join('c.status','s');
        $qb->where('s.id=3');
        if ($dateDebut and $dateFin) {
            $qb->andWhere('c.dateCommande between :dateDebut and :dateFin');
            $qb->setParameter('dateDebut', $dateDebut);
            $qb->setParameter('dateFin', $dateFin);
        }

        return $qb->getQuery()->getSingleResult()["count"];

    }

    public function montantByMonthAndYear($month, $year)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('sum(c.prixTotal) as prix');
        $qb->join('c.status','s');
        $qb->where('s.id=5');
        $qb->andWhere('month(c.dateCommande)= :month' );
        $qb->andWhere('year(c.dateCommande)= :year' );
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);
        return $qb->getQuery()->getSingleResult()["prix"];

    }
    public function cmdByMonthAndYear($month, $year)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        $qb->where('month(c.dateCommande)= :month' );
        $qb->andWhere('year(c.dateCommande)= :year' );
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);
        return $qb->getQuery()->getSingleResult()["count"];

    }

//    /**
//     * @return Commande[] Returns an array of Commande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
