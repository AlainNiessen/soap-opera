<?php

namespace App\Form;

use App\Entity\Langue;
use App\Entity\Utilisateur;
use App\Entity\NewsletterCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\TraductionNewsletterCategorie;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionUtilisateurType extends AbstractType
{
    // Injection du service request_stack => accés à la requête en appelant la méthode getCurrentRequest() 
    // pour pouvoir récupérer la langue dans la Session pour le choice_label du newsletterCategorie
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,[
            'label'=> new TranslatableMessage('formInscription.email', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ],            
        ])           
        
        ->add('plainPassword', RepeatedType::class, [
            'type'=>PasswordType::class,
            // message d'erreur au cas où le mot de passe et la confirmation ne sont pas identiques
            'invalid_message'=> 'formInscription.passwordInvalidIdent',
            'label'=> new TranslatableMessage('formInscription.password', [], 'Form'),
            'required'=>true,
            // champs mot de passe
            'first_options'=>[
                'label'=> new TranslatableMessage('formInscription.passwordLabel', [], 'Form'),
                'attr'=>[
                    'class'=>'form-control',
                ]
            ],            
            //champs confirmation du mot de passe
            'second_options'=>[
                'label'=> new TranslatableMessage('formInscription.passwordConfirmation', [], 'Form'),
                'attr'=>[
                    'class'=>'form-control',
                ]
            ]
        ]) 

        ->add('nomEntreprise', TextType::class, [
            'label'=> new TranslatableMessage('formInscription.nomEntreprise', [], 'Form'),
            'required'=>false,
            'attr'=>[
                'class'=>'form-control',
            ]
        ]) 
        ->add('numeroTVA', TextType::class, [
            'label'=> new TranslatableMessage('formInscription.numeroTVA', [], 'Form'),
            'required'=>false,
            'attr'=>[
                'class'=>'form-control',
            ]
        ]) 

        ->add('nom', TextType::class, [
            'label'=> new TranslatableMessage('formInscription.nom', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])  
          
        ->add('prenom', TextType::class, [
            'label'=> new TranslatableMessage('formInscription.prenom', [], 'Form'),
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])
        ->add('dateNaissance', BirthdayType::class, [
            'label' => new TranslatableMessage('formInscription.dateDeNaissance', [], 'Form'),
            'widget' => 'choice',
            'required'=>true,
            'attr'=>[
                'class'=>'form-control',
            ]
        ])
        ->add('adresseHome', AdresseType::class, [
            'label' => new TranslatableMessage('formInscription.adresseResi', [], 'Form'),
        ])
        ->add('adresseDeliver', AdresseType::class, [
            'label' => new TranslatableMessage('formInscription.adresseLivraison', [], 'Form'),
        ])
        ->add('ramassage', CheckboxType::class, [
            'label'    => new TranslatableMessage('formInscription.rammassage', [], 'Form'),
            'required' => false,
        ])
        ->add('newsletterCategories', EntityType::class, [
            'class' => NewsletterCategorie::class,
            'label' => new TranslatableMessage('formInscription.newsletterCategorie', [], 'Form'),
            'choice_label' => function (NewsletterCategorie $newsletterCategorie) {
                //récupération de la langue dans la Session
                $langue = $this -> request -> getLocale();
                // récupération de la traduction des catégories Newsletter via TraductionNewsletterCategorieRepository
                $repository = $this -> entityManager -> getRepository(TraductionNewsletterCategorie::class);
                $trad = $repository -> findTraduction($newsletterCategorie, $langue);                
                //récupération du nom de la catégorie dans la langue stockée dans la Session
                $categorieNom = $trad -> getNom();
                
                return $categorieNom;               
            },
            'multiple' => true,
            'expanded' => true,
            'required'=> false,
            'attr'=>[
                'class'=>'form-control',
            ]  
        ])
        ->add('langue', EntityType::class,[
            'label'=> new TranslatableMessage('formInscription.langue', [], 'Form'),
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
            // validations sur tous les propriétés et sur mot de passe (qui a le validation groupe inscription)
            'validation_groups' => ['Default', 'inscription']
            
        ]);
    }
}
