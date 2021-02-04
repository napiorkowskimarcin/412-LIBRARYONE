<?php

namespace App\Repository;

use App\Entity\Book;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Book::class);
        $this->paginator = $paginator;
    }
   


    //GET BOOKS AS PER DEMAND:
    public function findBooks(){}


    // FILTER BY SEARCH:
    public function findBySearchPaginated(int $page,?string $sort_method, ?int $limit,?string $search) {
        //sort
        $sort_method = $sort_method != 'other' ? $sort_method : 'ASC';
        $limit = $limit;
        $search = $search;
        if(!$search){
            $search = '';
        }
        
        //paginate and find by search
        $qb = $this->createQueryBuilder('b');
            $qb
                ->innerJoin('App\Entity\Author', 'a', Join::WITH, 'a = b.author')
                ->where($qb->expr()->orX(
                    $qb->expr()->like('b.title', ':search'),
                    $qb->expr()->like('b.ISBN', ':search'),
                    $qb->expr()->like('b.year', ':search'),
                    $qb->expr()->like('a.firstName', ':search'),
                    $qb->expr()->like('a.lastName', ':search'),
                ))
                ->setParameter('search', '%'.trim($search).'%'); 

        $dbquery =  $qb
            ->orderBy('b.title', $sort_method)
            ->getQuery();
        return $this->paginator->paginate($dbquery, $page, 5);
    }
}