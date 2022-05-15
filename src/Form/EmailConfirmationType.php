<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmailConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,[
            'label'=> 'Email',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]           
        ]) 
        ->add('submit', SubmitType::class,[
            'label'=> 'Bestätigen',
            'attr'=>[
                'class'=>'btn btn-primary submit-btn',
            ]
        ])  
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => false,
        ]);
    }
}
