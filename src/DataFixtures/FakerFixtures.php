<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\MovieAndGenreProvider;
use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker=Faker\Factory::create('fr_FR');

        $faker->seed(1337);

        $faker->addProvider(new MovieAndGenreProvider($faker));

        $genres=[];
        $persons=[];
        $movies=[];
        $castings=[];

        for ($i=0; $i<10; $i++){
            $genre = new Genre();
            $genre->setName($faker->movieGenre());
            $genre->setCreatedAt($faker->datetime());
            $manager->persist($genre);
            $genres[]=$genre;
        }

        for ($i=0; $i<30; $i++){
            $person = new Person();
            $person->setName($faker->firstname(). ' ' .$faker->lastname());
            $person->setCreatedAt($faker->datetime());
            $manager->persist($person);
            $persons[]=$person;
        }

        for ($i=0; $i<15; $i++){
            $movie = new Movie();
            $movie->setTitle($faker->movieTitle(4));
            $movie->setCreatedAt($faker->datetime());

            for($j=0; $j<mt_rand(1,3); $j++){
                 shuffle($genres);
                 $movie->addGenre($genres[0]);
            }
            
            
            $manager->persist($movie);
            $movies[]=$movie;
        }

        for ($i=0; $i<150; $i++){
            $casting = new Casting();
            $casting->setRole($faker->firstname());
            $casting->setCreditOrder($faker->numberBetween(1,120));
            

            shuffle($persons);
            shuffle($movies);

            $casting->setPerson($persons[0]);
            $casting->setMovie($movies[0]);

            $manager->persist($casting);
            $castings[]=$casting;
        }

        $manager->flush();
    }
}
