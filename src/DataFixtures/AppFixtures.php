<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        // $product = new Product();
        // $manager->persist($product);

        $genres=[];
        $persons=[];
        $movies=[];
        $castings=[];
        
        //Commencer par créer des Genres
        $genre = new Genre();
        $genre->setName('Horreur');
        $em->persist($genre);
        $genres[]=$genre;

        $genre = new Genre();
        $genre->setName('Comédie');
        $em->persist($genre);
        $genres[]=$genre;

        
        $person=new Person();
        $person->setName('Parène Pipoy');
        $em->persist($person);
        $persons[]=$person;

        $person=new Person();
        $person->setName('Kate Winslet');
        $em->persist($person);
        $persons[]=$person;

        $person=new Person();
        $person->setName('Leonardo Dicaprio');
        $em->persist($person);
        $persons[]=$person;

        $movie=new Movie();
        $movie->setTitle('Jurassic Park');
        $em->persist($movie);
        $movies[]=$movie;

        $movie=new Movie();
        $movie->setTitle('E.T.');
        $em->persist($movie);
        $movies[]=$movie;

        $movie=new Movie();
        $movie->setTitle('Bohemian Rhapsody');
        $em->persist($movie);
        $movies[]=$movie;


        $casting=new Casting();
        $casting->setRole('Néarque');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('E.T');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Bilbo');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Freddy');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Alex');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Obi-Wan');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('John');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Artour Cuillère');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        

        $casting=new Casting();
        $casting->setRole('Jack Gray');
        $casting->setCreditOrder(mt_rand(1,42));
        $em->persist($casting);
        $castings[]=$casting;

        
        foreach($movies as $currentMovie){
            
            shuffle($genres);
            $currentMovie->addGenre($genres[0]);
        }
        
        $currentMovie->addGenre($genres[1]);

        
        foreach($castings as $currentCasting){

            shuffle($persons);
            shuffle($movies);

            $currentCasting->setPerson($persons[0]);
            $currentCasting->setMovie($movies[0]);
        }

        $em->flush();
    }
}