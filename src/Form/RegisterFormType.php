<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'register-input']
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'register-input']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'register-input']
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'register-input']
            ])
            ->add('plainPasswordBis', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'register-input']
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de profil (tout types)',
                'mapped' => false, // Cette ligne signifie que ce champs ne sera associé à aucune propriété de l'entité
                'required' => false, // Permet de ne pas rendre ce champs obligatoire
                'attr' => ['accept' => 'image/*'] // Accepte tous les fichiers de type image
            ]);
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
