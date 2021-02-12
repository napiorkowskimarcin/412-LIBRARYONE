<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
*@Route("/author")
*/
class AuthorController extends AbstractController
{
    /**
    *@Route("/", name= "author_index", methods={"GET",})
    */
    public function index(AuthorRepository $authorRepository,Request $request): Response
    {
        if($request->get('search')){
            $search = $request->get('search');
            $authors = $authorRepository->findAuthor($search);
            $template = $this->render('author/_author_loop.html.twig', [
            'authors' => $authors,
            ])->getContent();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            return $response->setData(['template' => $template ]); 
        }else {
            $search = null;
            $authors = $authorRepository->findAuthor($search);
            return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
        }
    }

    /**
    *@Route("/new", name= "author_new", methods={"GET", "POST"})
    */
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }
    
    /** 
    *@Route("/{id}", name= "author_show", methods= {"GET"})
    */
    public function show(Author $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /** 
    *@Route("/{id}/edit", name= "author_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /** 
    *@Route("/{id}", name= "author_delete", methods= {"DELETE"})
    */
    public function delete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('author_index');
    }
}