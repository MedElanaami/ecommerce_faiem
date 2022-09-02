<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function add(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function nbrClients($dateDebut,$dateFin )
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        if ($dateDebut and $dateFin) {
            $qb->where('c.createdAt between :dateDebut and :dateFin');
            $qb->setParameter('dateDebut', $dateDebut);
            $qb->setParameter('dateFin', $dateFin);
        }

        return $qb->getQuery()->getSingleResult()["count"];

    }
    public function clientByMonthAndYear($month, $year)
    {
        $qb = $this->createQueryBuilder("c");
        $qb->select('count(c.id) as count');
        $qb->where('month(c.createdAt)= :month' );
        $qb->andWhere('year(c.createdAt)= :year' );
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);
        return $qb->getQuery()->getSingleResult()["count"];

    }
//    /**
//     * @return Client[] Returns an array of Client objects
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

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
