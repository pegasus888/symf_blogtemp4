<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Posts;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Title...',
                ),
                'label' => false,
//                'required' => false
            ])
            ->add('content',TextareaType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-60 text-6xl outline-none',
                    'placeholder' => 'Content...',
                ),
                'label' => false,
//                'required' => false
            ])
            ->add('image', FileType::class, array(
                'required' => false,
                'mapped' => false
            ))
            ->add('date', null, [
                'widget' => 'single_text',
//                'required' => false
            ])
            ->add('slug', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-20 text-2xl outline-none',
                    'placeholder' => 'Slug...',
                ),
                'label' => false,
//                'required' => false
            ])
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'username',
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'category',
//                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
