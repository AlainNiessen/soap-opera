<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countries = Countries::getNames();

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
                new Length([
                    'min' => 2,
                    'minMessage' => 'Die Straße muss mindestens {{ limit }} Zeichen lang sein!',
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
                new Length([
                    'min' => 4,
                    'max' => 5,
                    'minMessage' => 'Die Postleitzahl muss mindestens {{ limit }} Zeichen lang sein!',
                    'maxMessage' => 'Die Postleitzahl kann höchstens {{ limit }} Zeichen lang sein!',
                ]),
                new Regex([
                    'pattern' => '/^[0-9]*$/',
                    'match' => true,
                    'message' => 'Die Postleitzahl kann nur aus Ziffern bestehen!'                        
                ])
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
                new Length([
                    'min' => 2,
                    'minMessage' => 'Die Stadt muss mindestens {{ limit }} Zeichen lang sein!',
                ]),
            ],
        ])
        ->add('pays', CountryType::class,[
            'preferred_choices' => ['DE', 'BE'],
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
