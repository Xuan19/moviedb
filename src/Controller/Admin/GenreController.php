<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\DeleteType;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/admin/genre", name="admin_genre_")
     */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="browse")
     */
    public function browse(GenreRepository $genreRepository): Response
    {
        
        return $this->render('admin/genre/browse.html.twig',[
            'genres'=>$genreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id":"\d+"})
     */

    public function edit(Genre $genre, Request $request): Response
    {
        $form=$this->createForm(GenreType::class,$genre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $genre->setUpdatedAt(new \DateTime());

            $em=$this->getDoctrine()->getManager();

            $em->flush();
        }

        // $formDelete=$this->createFormBuilder()
        //                 ->setAction($this->generateUrl('admin_genre_delete',['id'=>$genre->getId()]))
        //                 ->setMethod('DELETE')
        //                 ->add('deleteButton',SubmitType::class,[
        //                     'label'=>'Supprimer',
        //                 ]) 
        //                 ->getForm();

        $formDelete=$this->createForm(DeleteType::class,null, [
            'action'=>$this->generateUrl('admin_genre_delete',['id'=>$genre->getId()])
        ]);

        return $this->render('admin/genre/edit.html.twig',[

            'form'=>$form->createView(),

            'formDelete'=>$formDelete->createView(),
        ]);
       
    }

    /**
     * @Route("/add", name="add")
     */

    public function add(Request $request): Response
    {
        $genre=new Genre();

        $form=$this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('admin_genre_browse');
        }

        return $this->render('admin/genre/add.html.twig',[
            'form'=>$form->createView(),
        ]);
       
    }

   /**
     * @Route("/delete/{id}", name="delete", requirements={"id":"\d+"})
     */

    public function delete(EntityManagerInterface $em, Genre $genre, Request $request): Response
       {

            $formDelete=$this->createForm(DeleteType::class);

            $formDelete->handleRequest($request);

            if($formDelete->isSubmitted() && $formDelete->isValid()){
    
                // $em=$this->getDoctrine()->getManager();
                $em->persist($genre);
                $em->flush();
    
            }
            
            return $this->redirectToRoute('admin_genre_browse');
    }
}
