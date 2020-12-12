<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use App\Form\DeleteType;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Services\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/admin/movie", name="admin_movie_")
     */
class MovieController extends AbstractController
{

    // private $slugger;

    // public function __construct(Slugger $slugger)
    // {
    //     $this->slugger=$slugger;
    // }
    /**
     * @Route("/", name="browse")
     */
    public function browse(MovieRepository $movieRepository): Response
    {
        
        return $this->render('admin/movie/browse.html.twig',[
            'movies'=>$movieRepository->findAll(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="edit", requirements={"id":"\d+"})
     */

    public function edit(Movie $movie, Request $request,Slugger $slugger): Response
    {

        //$this->denyAccessUnlessGranted('EDIT', $movie);
        
        $form=$this->createForm(MovieType::class,$movie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //dd($this->slugger->slugify($movie->getTitle()));
            //dd($slugger->slugify($movie->getTitle()));
            $movie->setSlug($slugger->slugify($movie->getTitle()));

            $movie->setUpdatedAt(new \DateTime());

            $em=$this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('admin_movie_browse');
        }

        // $formDelete=$this->createFormBuilder()
        //                 ->setAction($this->generateUrl('admin_Movie_delete',['id'=>$Movie->getId()]))
        //                 ->setMethod('DELETE')
        //                 ->add('deleteButton',SubmitType::class,[
        //                     'label'=>'Supprimer',
        //                 ]) 
        //                 ->getForm();

        $formDelete=$this->createForm(DeleteType::class,null, [
            'action'=>$this->generateUrl('admin_movie_delete',['id'=>$movie->getId()])
        ]);

        return $this->render('admin/movie/edit.html.twig',[

            'form'=>$form->createView(),

            'formDelete'=>$formDelete->createView(),
        ]);
       
    }

    /**
     * @Route("/add", name="add")
     */

    public function add(Request $request,Slugger $slugger): Response
    {
        $movie=new Movie();

        $form=$this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $movie->setSlug($slugger->slugify($movie->getTitle()));

            $em=$this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('admin_movie_browse');
        }

        return $this->render('admin/movie/add.html.twig',[
            'form'=>$form->createView(),
        ]);
       
    }

   /**
     * @Route("/delete/{id}", name="delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */

    public function delete(EntityManagerInterface $em, Movie $movie, Request $request): Response
       {

            $formDelete=$this->createForm(DeleteType::class);

            $formDelete->handleRequest($request);

            if($formDelete->isSubmitted() && $formDelete->isValid()){
    
                // $em=$this->getDoctrine()->getManager();
                $em->remove($movie);

                $em->flush();
    
            }
            
            return $this->redirectToRoute('admin_movie_browse');
    }
}
