<?php

namespace App\Form;

use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use App\Repository\GenreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('genres',null,[
                'expanded'=>true,
                'query_builder'=> function(EntityRepository $er){
                    return $er->createQueryBuilder('g')
                           ->orderBy('g.name','ASC');
                },

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
