<?php

namespace App\Controller\Admin;


use App\Entity\Genre;
use App\Form\GenreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/admin/genre/new", name="admin_genre_new")
     */
    public function new(Request $request): Response
    {
        $genre=new Genre();
        //$genre->setName('Thriller');
        $form=$this->createForm(GenreType::class, $genre);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            dd('formulaire envoyé et valide');
        }


        return $this->render('admin/genre/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
