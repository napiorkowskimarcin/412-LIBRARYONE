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
            ['ada', 'bbbbb'],
            ['adama', 'ggggg'],
            ['adamama', 'fffff'],
            ['dam', 'bbbbb'],
            ['dama', 'hhhhh'],
            ['mam', 'cccc'],
            ['mama', 'eeeee'],
            ['amama', 'aaaaa'],
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
            ['title7', 2000, 21122111, "one.jpg", '1'],
            ['title8', 2002, 21122112, "three.jpg", '2'],
            ['title9', 2003, 21122113, "four.jpg", '3'],
            ['title10', 2004, 21122114, "two.jpg", '4'],
            ['title11', 2005, 21122111, "three.jpg", '5'],
            ['title12', 2006, 21122111, "two.jpg", '6'],
            ['title13', 2000, 21122111, "one.jpg", '1'],
            ['title14', 2002, 21122112, "three.jpg", '2'],
            ['title15', 2003, 21122113, "four.jpg", '3'],
            ['title16', 2004, 21122114, "two.jpg", '4'],
            ['title17', 2005, 21122111, "three.jpg", '5'],
            ['title18', 2006, 21122111, "two.jpg", '6'],
            ['title19', 2000, 21122111, "one.jpg", '1'],
            ['title20', 2002, 21122112, "three.jpg", '2'],
            ['title21', 2003, 21122113, "four.jpg", '3'],
            ['title22', 2004, 21122114, "two.jpg", '4'],
            ['title23', 2005, 21122111, "three.jpg", '5'],
            ['title24', 2006, 21122111, "two.jpg", '6'],
            ['title25', 2000, 21122111, "one.jpg", '1'],
            ['title26', 2002, 21122112, "three.jpg", '2'],
            ['title27', 2003, 21122113, "four.jpg", '3'],
            ['title28', 2004, 21122114, "two.jpg", '4'],
            ['title29', 2005, 21122111, "three.jpg", '5'],
            ['title30', 2006, 21122111, "two.jpg", '6'],
            ];
    }
}