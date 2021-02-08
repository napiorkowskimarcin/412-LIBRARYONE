<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AuthorFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {
        $this->loadAuthors($manager);
        $this->loadBooks($manager);
        
    }


    public function loadAuthors(ObjectManager $manager)
    {
        foreach($this->getAuthorData() as $key =>  [$name1, $name2]){
        $author = new Author();
        $author->setFirstName($name1);
        $author->setLastName($name2);
        $manager->persist($author);
        $manager->flush();
        // $this->setReference('author'.$key, $author);
    }
}

    public function loadBooks(ObjectManager $manager)
    {
        foreach($this->getBookData() as [$title, $year, $ISBN, $page, $author_id]){
        $author = $manager->getRepository(Author::class)->find($author_id);
        $book = new Book();
        $book->setTitle($title);
        $book->setYear($year);
        $book->setISBN($ISBN);
        $book->setFrontPage($page);
        $book->setAuthor($author);
        $manager->persist($book);
        }
        $manager->flush();
    }

    private function getAuthorData(){
        return [
            ['aaaa', 'bbbbb'],
            ['bbbb', 'ggggg'],
            ['cccc', 'fffff'],
            ['ddddd', 'bbbbb'],
            ['eeee', 'hhhhh'],
            ['fffff', 'cccc'],
            ['gggg', 'eeeee'],
            ['hhhh', 'aaaaa'],
            
            ];
    }

    private function getBookData(){
        return [
            ['title1', 2000, 21122111, "one.jpg", '1'],
            ['title2', 2002, 21122112, "three.jpg", '2'],
            ['title3', 2003, 21122113, "four.jpg", '3'],
            ['title4', 2004, 21122114, "two.jpg", '4'],
            ['title5', 2005, 21122111, "three.jpg", '5'],
            ['title6', 2006, 21122111, "two.jpg", '6'],
            ];
    }
}