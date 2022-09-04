<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function add(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function selectParPrixDescendant($categorie): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.categories','categorie')
            ->andWhere('categorie = :cat')
            ->setParameter('cat', $categorie)
            ->orderBy('c.prixVente','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function selectParPrixAscendant($categorie): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.categories','categorie')
            ->andWhere('categorie = :cat')
            ->setParameter('cat', $categorie)
            ->orderBy('c.prixVente','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function selectParPromo($categorie): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.categories','categorie')
            ->andWhere('categorie = :cat')
            ->andWhere('c.reductionApplique=true')
            ->setParameter('cat', $categorie)
            ->getQuery()
            ->getResult();
    }
}
