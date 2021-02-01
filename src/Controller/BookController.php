<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Repository\AuthorRepository;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
    /** 
    *@Route("/show/{page}", name= "book_index",  defaults={"page":1,"author": 0})
    */
    public function index(AuthorRepository $authorRepository, BookRepository $bookRepository,PaginatorInterface $paginator,Request $request,?int $page, ?int $author): Response
    {
        $authors =$authorRepository->findAll() ;

        $author = $request->query->get('author');
        
        //case author is selected
        if($author >0) {
        $books = $this->getDoctrine()
        ->getRepository(Book::class)
        ->findByAuthPaginated($page, $request->get('sortby'), $request->get('limit',3), $author);
        return $this->render('book/index.html.twig', [
            'books' => $books,
            'authors' => $authors,
        ]);
        };

        $books = $this->getDoctrine()
        ->getRepository(Book::class)
        ->findAllPaginated($page, $request->get('sortby'), $request->get('limit',3));


        
        return $this->render('book/index.html.twig', [
            'books' => $books,
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'book_delete', methods: ['DELETE'])]
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_index');
    }
}