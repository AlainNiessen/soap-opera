<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // les messages de contraintes font références aux messages de contraintes définis dans les entités dans les annotation
        // les tradcution se font dans les fichiers validators.xlf

        $supportedCountries = ['BE', 'DE'];

        $builder
        
        ->add('rue', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.rue', [], 'Form'),
            'empty_data' => '',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
        ])
        ->add('numeroRue', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.rueNumero', [], 'Form'),
            'empty_data' => '',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
        ])
        ->add('codePostal', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.codePostal', [], 'Form'),
            'empty_data' => '',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
        ])
        ->add('ville', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.ville', [], 'Form'),
            'empty_data' => '',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
        ])
        ->add('pays', CountryType::class,[
            // limiter le choix des pays à Belgique et Allemagne
            'choice_filter' => function ($countryName) use ($supportedCountries) {
                return in_array($countryName, $supportedCountries, true);
            },
            'empty_data' => '',
            'label'=> new TranslatableMessage('formAdresse.pays', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
        ])
        ->add('submit', SubmitType::class,[
            'label'=> new TranslatableMessage('form.boutonConfirmation', [], 'Form'),
            'attr'=>[
                'class'=>'btn btn-primary submit-btn',
            ]
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
