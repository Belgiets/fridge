<?php

namespace AppBundle\Form;

use AppBundle\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('save', SubmitType::class, array('label' => 'Save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Food::class,
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'app_bundle_food_type';
    }
}