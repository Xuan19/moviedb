<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\MovieAndGenreProvider;
use Nelmio\Alice\Faker\Provider\AliceProvider;
use Faker\Factory as FakerGeneratorFactory;
use Faker\Generator as FakerGenerator;
use Nelmio\Alice\Loader\NativeLoader;

//ajout du provider custom

class MovieDbNativeLoader extends NativeLoader
{
    protected function createFakerGenerator(): FakerGenerator
    {
        $generator = FakerGeneratorFactory::create('fr_FR');

        $generator->addProvider(new AliceProvider());

        //ajout du nouveau provider en passant le generator dans le constructeur de notre classe (heritée du parent base)
        $generator->addProvider(new MovieAndGenreProvider($generator));

        // $generator->seed($this->getSeed());

        return $generator;
    }
}