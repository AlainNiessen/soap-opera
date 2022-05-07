<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('rue', TextType::class,[
            'label'=> 'Straße',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
                new NotNull([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
            ],
        ])
        ->add('numeroRue', TextType::class,[
            'label'=> 'Nummer',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
                new NotNull([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
            ],
        ])
        ->add('codePostal', TextType::class,[
            'label'=> 'Postleitzahl',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
                new NotNull([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
            ],
        ])
        ->add('ville', TextType::class,[
            'label'=> 'Stadt',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
                new NotNull([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
            ],
        ])
        ->add('pays', TextType::class,[
            'label'=> 'Land',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
                new NotNull([
                    'message' => 'Dieses Feld muss ausgefüllt werden!'
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
