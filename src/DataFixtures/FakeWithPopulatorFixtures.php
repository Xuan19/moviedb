<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\MovieAndGenreProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;
use Faker;

class FakeWithPopulatorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $generator=Faker\Factory::create('fr_FR');

        $generator->addProvider(new MovieAndGenreProvider($generator));

        $populator = new Populator($generator, $manager);

        $populator->addEntity('App\Entity\Genre',20, [
            'name'=>function() use ($generator){return $generator->unique()->movieGenre();},
        ]);

        $populator->addEntity('App\Entity\Person',20, [
            'name'=>function() use ($generator){return $generator->name();},
        ]);

        $populator->addEntity('App\Entity\Movie',10, [
            'title'=>function() use ($generator){return $generator->unique()->movieTitle();},
        ]);

        $populator->addEntity('App\Entity\Casting',50, [
            'creditOrder'=>function() use ($generator){return $generator->numberBetween(1,120);},
            'role'=>function() use ($generator){return $generator->firstName();},
        ]);

        $inserted=$populator->execute();

        $movies=$inserted['App\Entity\Movie'];
        $genres=$inserted['App\Entity\Genre'];


         foreach($movies as $movie){

            for($j=0; $j<mt_rand(1,3); $j++){
                shuffle($genres);
                $movie->addGenre($genres[0]);
           }
           
         }

        $manager->flush();
    }
}
