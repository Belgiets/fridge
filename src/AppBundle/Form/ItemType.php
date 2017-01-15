<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Food;
use AppBundle\Entity\Item;

use AppBundle\Entity\Shelf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'required' => true
            ])
            ->add('qty', IntegerType::class, [
                'required' => false
            ])
            ->add('weight', NumberType::class, [
                'required' => false
            ])
            ->add('food', EntityType::class, [
                'class' => Food::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => true
                ]
            ])
            ->add('shelf', EntityType::class, [
                'class' => Shelf::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => true
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => true
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Item::class,
            'csrf_protection' => false,
            'user' => null
        ));
    }

    public function getName()
    {
        return 'app_bundle_item_type';
    }
}
