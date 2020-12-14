<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
//use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles',CollectionType::class,[
            //     'entry_type' => TextType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
            // ])
            ->add('roles', ChoiceType::class,[
                'choices'=>[
                    'Adeministrateur'=>'ROLE_ADMIN',
                    'Utilisateur'=>'ROLE_USER',
                ],
                'multiple'=>true,
                'expanded'=>true,
            ])
            ->add('password',RepeatedType::class,[
                 'type'=>PasswordType::class,
                 'mapped'=>false,
                 'required'=>false,
                 'first_options'  => ['label' => 'Mot de passe'],
                 'second_options' => ['label' => 'Retapez le mot de passe'],
                 'constraints' => [
                     new Assert\NotBlank([
                         'allowNull'=>true,
                         'normalizer'=>'trim',
                     ]),
                     new Assert\Length(['min' => 2,])
                 ]
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){

                //dd($event);
              $form=$event->getForm();
              $user=$event->getData();

              if($user->getId()===null){
                  $form->add('cgu', CheckboxType::class, [
                      'label'=>'J\'accepte les CGU',
                      'required'=>true,
                      'mapped'=>false,
                  ]);

                  $form->remove('password')

                  ->add('password',RepeatedType::class,[
                    'type'=>PasswordType::class,
                    'mapped'=>false,
                    'required'=>true,
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Retapez le mot de passe'],
                    'constraints' => [
                        new Assert\NotBlank([
                            'allowNull'=>true,
                            'normalizer'=>'trim',
                        ]),
                        new Assert\Length(['min' => 2,])
                    ]
               ]);
                
              }


            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
