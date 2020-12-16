<?php

namespace App\Controller\Api\V1;

use App\Entity\Movie;
use App\Services\Slugger;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

 /**
     * @Route("/api/v1/movies", name="api_v1_movie_")
     */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(MovieRepository $movieRepository, SerializerInterface $serializer): Response
    {
        $movies=$movieRepository->findAll();

        $arrayMovies=$serializer->normalize($movies,null,['groups'=>'movie_browse']);

        //dd($arrayMovies);

        return $this->json($arrayMovies);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function read(Movie $movie, SerializerInterface $serializer): Response
    {

        $arrayMovie=$serializer->normalize($movie,null,['groups'=>'movie_read']);

        //dd($arrayMovies);

        return $this->json($arrayMovie);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request,SerializerInterface $serializer,Slugger $slugger)
    {
       $jsonData=json_decode($request->getContent());

       $movie=new Movie();

       $movie->setTitle($jsonData->title);
       $movie->setSlug($slugger->slugify($movie->getTitle()));

       $em=$this->getDoctrine()->getManager();
       $em->persist($movie);
       $em->flush();

       return $this->json(
        $serializer->normalize(
            $movie,
            null,
            ['groups'=>'movie_read']),
           201);
    }
}
