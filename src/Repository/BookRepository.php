<?php

namespace App\Repository;

use App\Entity\Book;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;


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
    // SUPPORT - CASE - GET ALL BOOKS
    public function findAllPaginated(int $page,?string $sort_method, ?int $limit) {
        //sort
        $sort_method = $sort_method != 'other' ? $sort_method : 'ASC';
        $limit = $limit;
       
        
        //paginate
        $dbquery = $this->createQueryBuilder('v')
        ->orderBy('v.title', $sort_method)
        ->getQuery();

        $pagination = $this->paginator->paginate($dbquery, $page, $limit);
        return $pagination;
    }

    // SUPPORT - CASE - FILTER BY AUTHOR:
    public function findByAuthPaginated(int $page,?string $sort_method, ?int $limit, $author) {
        //sort
        $sort_method = $sort_method != 'other' ? $sort_method : 'ASC';
        $limit = $limit;
        $author = $author;
        
        //paginate
        $dbquery = $this->createQueryBuilder('v')
        ->where('v.author = :author')
        ->setParameter('author', $author)
        ->orderBy('v.title', $sort_method)
        ->getQuery();

        $pagination = $this->paginator->paginate($dbquery, $page, $limit);
        return $pagination;
    }   


    //GET BOOKS AS PER DEMAND:
    public function findBooks(){}


    // SUPPORT - CASE - FILTER BY TITLE:
    public function findBySearchPaginated(int $page,?string $sort_method, ?int $limit,?string $search) {
        //sort
        $sort_method = $sort_method != 'other' ? $sort_method : 'ASC';
        $limit = $limit;
        $search = $search;
        
        //paginate and find by title
        $querybuilder = $this->createQueryBuilder('v');
        $searchTerms = $this->prepareQuery($search);

        foreach ($searchTerms as $key => $term)
        {
            $querybuilder
                ->orWhere('v.title LIKE :t_'.$key)
                ->setParameter('t_'.$key, '%'.trim($term).'%'); 
        }

        $dbquery =  $querybuilder
            ->orderBy('v.title', $sort_method)
            ->getQuery();

        return $this->paginator->paginate($dbquery, $page, 5);
    }

 private function prepareQuery(string $query): array
    {
        return explode(' ',$query);
    }


    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}