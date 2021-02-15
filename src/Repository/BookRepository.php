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
   
    public function findBySearchPaginated(int $page,?string $sort_method, ?int $limit,?string $searchTitle,?string $searchIsbn, ?string $searchAuthor) {
        //sort and variables
        $sort_method = $sort_method != 'other' ? $sort_method : 'ASC';
        $limit = $limit;
        $searchTitle = $searchTitle;
        $searchAuthor = $searchAuthor;
        $searchIsbn = $searchIsbn;

        //case no search
        if(!$searchTitle && !$searchIsbn && !$searchAuthor){
            $dbquery = $this->createQueryBuilder('b')
            ->orderBy('b.title', $sort_method)
            ->getQuery();
            return $this->paginator->paginate($dbquery, $page, $limit);

        }else {
            
        if($searchTitle){
        $qb = $this->createQueryBuilder('b');
            $qb
                ->where($qb->expr()->orX(
                    $qb->expr()->like('b.title', ':search'),
                ))
                ->setParameter('search', '%'.trim($searchTitle).'%'); 
        } 
        if ($searchAuthor){
             $qb = $this->createQueryBuilder('b');
            $qb
                ->innerJoin('App\Entity\Author', 'a', Join::WITH, 'a = b.author')
                ->where($qb->expr()->orX(
                    $qb->expr()->like('a.firstName', ':search'),
                    $qb->expr()->like('a.lastName', ':search'),
                ))
                ->setParameter('search', '%'.trim($searchAuthor).'%');
        }
        if ($searchIsbn){
            $qb = $this->createQueryBuilder('b');
            $qb
                ->where($qb->expr()->orX(
                $qb->expr()->like('b.ISBN', ':search'),
                ))
                ->setParameter('search', '%'.trim($searchIsbn).'%'); 
        
        }
        return $dbquery =  $qb
            ->orderBy('b.title', $sort_method)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
}