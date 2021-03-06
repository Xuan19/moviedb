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

        //dd($this->getParameter('app.project_name'));

        return $this->render('movie/browse.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie_read",requirements={"id":"\d+"})
     */
    public function readId(Movie $movie, MovieRepository $movieRepository): Response
    {
        return $this->redirectToRoute('movie_read_slug', [
            'slug'=>$movie->getSlug(),
        ]);
    }


     /**
     * @Route("/movie/{slug}", name="movie_read_slug")
     */

    public function read(Movie $movie, MovieRepository $movieRepository): Response
    {
        // $em=$this->getDoctrine()->getManager();

        // $qb = $em->createQueryBuilder();

        // $qb
        //    ->from('App\Entity\Movie', 'm')
        //    ->select('m')

        //    ->join('m.genres', 'g')
        //    ->addSelect('g')

        //    ->where('m.id=:id')
        //    ->setParameter('id',$id)

        //    ->join('m.castings', 'c')
        //    ->addSelect('c')

        //    ->join('c.person', 'p')
        //    ->addSelect('p')

        //    ;
        
        // $movie=$qb->getQuery()->getOneOrNullResult();

        
        //$movie= $movieRepository->getMovieWithRelations($id);

        // dd($movie);
        
        if($movie===null){
            throw $this->createNotFoundException('ce film n\'existe pas');
        }
        return $this->render('movie/read.html.twig', [
            'movie'=>$movie,
        ]);
    }
}
