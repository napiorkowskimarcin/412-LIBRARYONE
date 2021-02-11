<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findAuthor(?string $search) {
        $search = $search;
        $qb = $this->createQueryBuilder('a');
        
        if($search){
        //case search
            $qb
                ->where($qb->expr()->orX(
                    $qb->expr()->like('a.firstName', ':search'),
                    $qb->expr()->like('a.lastName', ':search'),
                ))
                ->setParameter('search', '%'.trim($search).'%'); 
                }
        return $qb
            ->orderBy('a.lastName', 'ASC' )
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}