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
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // les messages de contraintes font références aux messages de contraintes définis dans les entités dans les annotation
        // les tradcution se font dans les fichiers validators.xlf

        $supportedCountries = ['BE', 'DE'];

        $builder
        
        ->add('rue', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.rue', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'adresse.rue.not_blank',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'adresse.rue.length_min',
                ]),
            ],
        ])
        ->add('numeroRue', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.rueNumero', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'adresse.numeroRue.not_blank',
                ]),
            ],
        ])
        ->add('codePostal', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.codePostal', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'adresse.codePostal.not_blank',
                ]),
                new Length([
                    'min' => 4,
                    'max' => 5,
                    'minMessage' => 'adresse.codePostal.length_min',
                    'maxMessage' => 'adresse.codePostal.length_max',
                ]),
                new Regex([
                    'pattern' => '/^[0-9]*$/',
                    'match' => true,
                    'message' => 'adresse.codePostal.regex',                      
                ])
            ],
        ])
        ->add('ville', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.ville', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'adresse.ville.not_blank',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'adresse.ville.length_min',
                ]),
            ],
        ])
        ->add('pays', CountryType::class,[
            // limiter le choix des pays à Belgique et Allemagne
            'choice_filter' => function ($countryName) use ($supportedCountries) {
                return in_array($countryName, $supportedCountries, true);
            },
            'label'=> new TranslatableMessage('formAdresse.pays', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'adresse.pays.not_blank',
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
