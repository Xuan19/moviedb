<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name',TextareaType::class)jj
           //->add('submit', SubmitType::class)
           ->add('name',null,[
               'constraints' =>[
                   new Length([
                       'min'=>3,
                       'minMessage'=>'Stro court'
                       
                       ]),
                   new NotBlank([
                       'message' => "le champ est vide mais faut pas",
                   ]),
               ]
           ])
           ->add('movies')
        //    ->add('messages',TextType::class,[
        //        'mapped' => false,
        //    ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
        ]);
    }
}
