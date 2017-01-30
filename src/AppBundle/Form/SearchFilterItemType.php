<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Food;
use AppBundle\Entity\Shelf;
use AppBundle\Entity\User\BaseUser;
use AppBundle\Form\Model\SearchFilterItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFilterItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'description'
                ]
            ])
            ->add('food', EntityType::class, [
                'class' => Food::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => false
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => false
                ]
            ])
            ->add('shelf', EntityType::class, [
                'class' => Shelf::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => false
                ]
            ])
            ->add('created_start', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'created from'
                ]
            ])
            ->add('created_end', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'created to'
                ]
            ])
            ->add('created_by', EntityType::class, [
                'class' => BaseUser::class,
                'choice_label' => 'name',
                'attr' => [
                    'required' => false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SearchFilterItem::class,
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'app_bundle_search_filter_item_type';
    }
}
