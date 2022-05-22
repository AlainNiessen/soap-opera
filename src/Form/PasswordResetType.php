<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class PasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type'=>PasswordType::class,
                // message d'erreur au cas où le mot de passe et la confirmation ne sont pas identiques
                'invalid_message'=> new TranslatableMessage('formResetPassword.passwordInvalidIdent', [], 'Form'),
                'label'=> new TranslatableMessage('formResetPassword.password', [], 'Form'),
                'required'=>true,
                // champs mot de passe
                'first_options'=>[
                    'label'=> new TranslatableMessage('formResetPassword.passwordLabel', [], 'Form'),
                    'attr'=>[
                        'class'=>'form-control',
                    ]
                ],            
                //champs confirmation du mot de passe
                'second_options'=>[
                    'label'=> new TranslatableMessage('formResetPassword.passwordConfirmation', [], 'Form'),
                    'attr'=>[
                        'class'=>'form-control',
                    ]
                ]
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
            'data_class' => Utilisateur::class,
        ]);
    }
}
