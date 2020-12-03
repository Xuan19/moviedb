<?php

namespace App\DataFixtures\Providers;

use Faker\Provider\Base as BaseProvider;

class MovieAndGenreProvider extends BaseProvider

{

     protected static $movies=[
         "Lucy",
         "Tom and Jeryy",
         "Lucy1",
         "Tom and Jeryy1",
         "Lucy2",
         "Tom and Jeryy2",
         "Lucy3",
         "Tom and Jeryy3",
         "Lucy4",
         "Tom and Jeryy4",
         "Lucy5",
         "Tom and Jeryy5",
         "Lucy6",
         "Tom and Jeryy6",
     ];

     protected static $genres=[
         "Action",
         "Animation"
     ];

     public static function movieTitle(){
         
         return static::randomElement(static::$movies);
     }

     public static function movieGenre(){

         return static::randomElement(static::$genres);
     }



}