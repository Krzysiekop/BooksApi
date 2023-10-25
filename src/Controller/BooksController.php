<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Books;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BooksController extends AbstractController
{
    #[Route('/books', name: 'show_books' , methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $books = $doctrine->getRepository(Books::class)->findAll();

        if (!$books) {
            return $this->json('No book found ', 404);
        }

        $data = [];
        foreach ($books as $book){
            $data[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'pages' => $book->getPages()
            ];
        }

        return $this->json([$data]);
    }

    #[Route('/books/{id}', name: 'show_book' , methods: ['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $books = $doctrine->getRepository(Books::class)->find($id);

        if (!$books) {
            return $this->json('No book found for id ' . $id, 404);
        }

            $data[] = [
                'id' => $books->getId(),
                'title' => $books->getTitle(),
                'pages' => $books->getPages()
            ];

        return $this->json([$data]);
    }

    #[Route('/book/delete/{id}', name: 'delete_book', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            return $this->json('No book found for id' . $id, 404);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json('Deleted id' . $id);
    }

    #[Route('/book/create', name: 'create_book', methods:['post'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $book = new Books();
        $book->setTitle($request->request->get('title'));
        $book->setPublisher($request->request->get('publisher'));
        $book->setPages($request->request->get('pages'));

        $entityManager->persist($book);
        $entityManager->flush();

        $data =  [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'publisher' => $book->getPublisher(),
            'pages' => $book->getPages()
        ];

        return $this->json($data);
    }

    #[Route('/author/create', name: 'create_author', methods:['post'] )]
    public function createAuthor(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $author = new Author();
        $author->setName($request->request->get('name'));
        $author->setCountry($request->request->get('country'));


        $entityManager->persist($author);
        $entityManager->flush();

        $data =  [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'country' => $author->getCountry(),
        ];

        return $this->json($data);
    }

    #[Route('/author/delete/{id}', name: 'delete_book', methods:['delete'] )]
    public function deleteAuthor(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $author = $entityManager->getRepository(Books::class)->find($id);

        if (!$author) {
            return $this->json('No author found for id' . $id, 404);
        }

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->json('Deleted id' . $id);
    }

    #[Route('/author/{name}', name: 'show_author' , methods: ['get'])]
    public function showAuthor(ManagerRegistry $doctrine, string $name): JsonResponse
    {
        $author= $doctrine->getRepository(Author::class)->findOneBy(array('name' => $name));

        if (!$author) {
            return $this->json('No author found for name ' . $name, 404);
        }

        $data[] = [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'country' => $author->getCountry()
        ];

        return $this->json([$data]);
    }

    #[Route('books/author/{name}', name: 'show_author' , methods: ['get'])]
    public function showAuthorBooks(ManagerRegistry $doctrine, string $name): JsonResponse
    {
        $author= $doctrine->getRepository(Author::class)->findOneBy(array('name' => $name));

        if (!$author) {
            return $this->json('No author found for name ' . $name, 404);
        }

        $books = $author->getBooks();

        if (!$books) {
            return $this->json('No books found for name ' . $name, 404);
        }

        $data = [];
        foreach ($books as $book){
            $data[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'pages' => $book->getPages()
            ];
        }

        return $this->json([$data]);
    }
}
