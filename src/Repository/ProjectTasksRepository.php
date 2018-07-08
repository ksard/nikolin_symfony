<?php

namespace App\Repository;

use App\Entity\ProjectTasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectTasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTasks[]    findAll()
 * @method ProjectTasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTasksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectTasks::class);
    }

//    /**
//     * @return ProjectTasks[] Returns an array of ProjectTasks objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectTasks
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
