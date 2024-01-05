<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findProjectByName(string $query){
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.name', ':query'),
                    ),
                    
                )
            )
            ->setParameter('query', '%' . $query . '%');
        return $qb
        ->getQuery()
        ->getResult();
    }

    public function sortingByDateDecrease(){
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.date', 'p')
            ->orderBy('u.date', 'DESC');
        return $qb
        ->getQuery()
        ->getResult();
    }

    public function sortingByDateGrowing(){
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.date', 'p')
            ->orderBy('u.date', 'ASC');
        return $qb
        ->getQuery()
        ->getResult();
    }

    public function sortingByNameDecrease(){
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.name', 'p')
            ->orderBy('u.name', 'DESC');
        return $qb
        ->getQuery()
        ->getResult();
    }

    public function sortingByNameGrowing(){
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.name', 'p')
            ->orderBy('u.name', 'ASC');
        return $qb
        ->getQuery()
        ->getResult();
    }
}