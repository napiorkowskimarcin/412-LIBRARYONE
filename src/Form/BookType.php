<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('frontPage',FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
                'attr' => [
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