<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_browse")
     */
    public function browse(MovieRepository $movieRepository): Response
    {
        return $this->render('movie/browse.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }


     /**
     * @Route("/movie/{id}", name="movie_read",requirements={"id":"\d+"})
     */

    public function read(Movie $movie): Response
    {
        return $this->render('movie/read.html.twig', [
            'movie' => $movie,
        ]);
    }
}
