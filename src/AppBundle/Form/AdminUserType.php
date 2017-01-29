<?php

namespace AppBundle\Form;

use AppBundle\Entity\User\AdminUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'required' => true
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $user = $event->getData();
                $form = $event->getForm();

                $form->add('password', RepeatedType::class, [
                    'property_path' => 'plainPassword',
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'New password',
                    ],
                    'second_options' => [
                        'label' => 'Repeat new password',
                        'attr' => [
                            'class' => 'required-field'
                        ]
                    ],
                    'required' => $user->getId() ? false : true
                ]);
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
                /** @var AdminUser $user */
                $user = $event->getData();
                $newPassword = $user->getPlainPassword();
                $encoder = $options['password_encoder'];

                if ($newPassword && $encoder instanceof UserPasswordEncoderInterface) {
                    $user->setPassword($encoder->encodePassword($user, $newPassword));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AdminUser::class,
            'password_encoder' => null
        ));

        $resolver->setAllowedTypes('password_encoder', [UserPasswordEncoderInterface::class]);
    }

    public function getName()
    {
        return 'app_bundle_admin_user_type';
    }
}
