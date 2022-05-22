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
        $builder
        
        ->add('rue', TextType::class,[
            'label'=> new TranslatableMessage('formAdresse.rue', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => new TranslatableMessage('formAdresse.not_blank', [], 'Form'),
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => new TranslatableMessage('formAdresse.rue_length_min', [], 'Form'),
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
                    'message' => new TranslatableMessage('formAdresse.not_blank', [], 'Form'),
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
                    'message' => new TranslatableMessage('formAdresse.not_blank', [], 'Form'),
                ]),
                new Length([
                    'min' => 4,
                    'max' => 5,
                    'minMessage' => new TranslatableMessage('formAdresse.cp_length_min', [], 'Form'),
                    'maxMessage' => new TranslatableMessage('formAdresse.cp_length_max', [], 'Form'),
                ]),
                new Regex([
                    'pattern' => '/^[0-9]*$/',
                    'match' => true,
                    'message' => new TranslatableMessage('formAdresse.cp_only_number_regex', [], 'Form'),                      
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
                    'message' => new TranslatableMessage('formAdresse.not_blank', [], 'Form'),
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => new TranslatableMessage('formAdresse.ville_length_min', [], 'Form'),
                ]),
            ],
        ])
        ->add('pays', CountryType::class,[
            'preferred_choices' => ['BE', 'DE'],
            'label'=> new TranslatableMessage('formAdresse.pays', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => new TranslatableMessage('formAdresse.not_blank', [], 'Form'),
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
