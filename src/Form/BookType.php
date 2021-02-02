<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'attr' => [
                    'placeholder'=> 'title',
                    'class'=> 'row'
                ]
            ])
            ->add('year',TextType::class, [
                'attr' => [
                    'placeholder'=> 'year',
                    'class'=> 'row'
                ]
            ])
            ->add('ISBN',TextType::class, [
                'attr' => [
                    'placeholder'=> 'ISBN',
                    'class'=> 'row'
                ]
            ])
            ->add('frontPage',TextType::class, [
                'attr' => [
                    'placeholder'=> 'front page',
                    'class'=> 'row'
                ]
            ])
            ->add('author',null, [
                'attr' => [
                    'class'=> 'row'
                ]
            ])
             ->add('save', SubmitType::class, [
                'attr' => ['class' => ' btn btn-primary save'],
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}