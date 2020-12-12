<?php

namespace App\DataFixtures;

//use Nelmio\Alice\Loader\NativeLoader;
use App\Entity\Movie;
use App\Entity\User;
use App\Services\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NelmioAliceFixtures extends Fixture
{

    private $slugger;
    private $passwordEncoder;

    public function __construct(Slugger $slugger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->slugger=$slugger;
        $this->passwordEncoder=$passwordEncoder;
    }

    public function load(ObjectManager $em)
    {
        $loader = new MovieDbNativeLoader();
        
        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__.'/fixtures.yml')->getObjects();
        
        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {
            if ($entity instanceof Movie){
                $entity->setSlug($this->slugger->slugify($entity->getTitle()));
            }elseif ($entity instanceof User){
                $encodedPassword=$this->passwordEncoder->encodePassword($entity,'Derrick');
                $entity->setPassword($encodedPassword);
            }
            $em->persist($entity);
        };
        
        //enregistre
        $em->flush();
    }
}

