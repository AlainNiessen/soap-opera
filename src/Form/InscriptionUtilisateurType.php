<?php

namespace App\Form;

use App\Entity\Langue;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Email;

class InscriptionUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,[
            'label'=> 'Email',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            
        ])           
        
        ->add('plainPassword', RepeatedType::class, [
            'type'=>PasswordType::class,
            // message d'erreur au cas où le mot de passe et la confirmation ne sont pas identiques
            'invalid_message'=> 'Das Passwort und die Bestätigung müssen identisch sein!',
            'label'=>'Passwort',
            'required'=>true,
            // champs mot de passe
            'first_options'=>[
                'label'=>'Passwort',
                'attr'=>[
                    'class'=>'form-control',
                ]
            ],            
            //champs confirmation du mot de passe
            'second_options'=>[
                'label'=>'Bestätigen Sie bitte Ihr Passwort',
                'attr'=>[
                    'class'=>'form-control',
                ]
            ]
        ])            
        ->add('nom', TextType::class, [
            'label'=> 'Name',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])  
          
        ->add('prenom', TextType::class, [
            'label'=> 'Vorname',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])
        ->add('dateNaissance', BirthdayType::class, [
            'label' => 'Geburtsdatum',
            'widget' => 'choice',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])
        ->add('adresseHome', AdresseType::class, [
            'label' => 'Wohnadresse',
            'constraints' => [
                new NotBlank()                
            ],
        ])
        ->add('adresseDeliver', AdresseType::class, [
            'label' => 'Lieferadresse',
            'constraints' => [
                new NotBlank()                
            ],
        ])
        ->add('langue', EntityType::class,[
            'label'=> 'Sprache',
            'class'=> Langue::class,
            'choice_label' => 'langue',
            'multiple' => false,
            'expanded' => false,
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
            
        ]);
    }
}
