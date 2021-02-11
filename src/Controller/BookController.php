<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;

use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

/** 
*@Route("/book")
*/
class BookController extends AbstractController
{
    /** 
    *@Route("/show/{page}", name= "book_index",  defaults={"page":1})
    */
    public function index(AuthorRepository $authorRepository, BookRepository $bookRepository,Request $request,?int $page, ?string $search): Response
    {
        //FORM - TO SHOW FIRST NAMES AND LAST NAMES IN SELECT INPUT - FILTERING BY AUTHOR:
        $authors =$authorRepository->findAll() ;
        //VARIABLES FROM QUERY:
        $search = $request->query->get('search'); 
        
        $books = $bookRepository
        ->findBySearchPaginated($page, $request->get('sortby'), $request->get('limit',5), $search);
        
        return $this->render('book/index.html.twig', [
            'books' => $books,
            'authors' => $authors,
        ]);
    }
    
    /**
    *@Route("/new", name= "book_new", methods={"GET", "POST"})
    */
    public function new(Request $request ,SluggerInterface $slugger): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //load file: 
            $frontPageFile = $form->get('frontPage')->getData();

            if ($frontPageFile) {
                $originalFilename = pathinfo($frontPageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$frontPageFile->guessExtension();

                try {
                    $frontPageFile->move(
                        $this->getParameter('frontpages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $book->setFrontPage($newFilename);
            }

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
    
    /** 
    *@Route("/{id}", name= "book_show", methods= {"GET"})
    */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
    
    /** 
    *@Route("/{id}/edit", name= "book_edit", methods={"GET", "POST"})
    */
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
    
    /** 
    *@Route("/{id}", name= "book_delete", methods= {"DELETE"})
    */
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