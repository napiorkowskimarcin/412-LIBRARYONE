<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class, [
                'attr' => [
                    'placeholder'=> 'first name',
                    'class'=> 'row'
                ]
            ])
            ->add('lastName',TextType::class, [
                'attr' => [
                    'placeholder'=> 'last name',
                    'class'=> 'row mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => ' btn btn-primary save'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}