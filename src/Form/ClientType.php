<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['attr' => ['class' => 'w3-input'],
                                 'label' => 'nome'])
            ->add('email', EmailType::class, ['attr' => ['class' => 'w3-input'],
                                              'label' => 'email'])
            ->add('phone', PhoneNumberType::class, ['attr' => ['class' => 'w3-input'],
                                                    'label' => 'telefone',
                                                    'default_region' => 'BR', 'format' => PhoneNumberFormat::NATIONAL])
            /*->add('phone', PhoneNumberType::class, ['attr' => ['class' => 'w3-input'],
                                                    'label' => 'telefone',
                                                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                                                    'country_choices' => ['BR', 'GB', 'FR', 'US'],
                                                    'preferred_country_choices' => ['BR', 'GB']])*/
            ->add('photo', FileType::class, ['attr' => ['class' => 'w3-input'],
                                             'data_class' => null,
                                             'required' => false,
                                             'label' => 'foto']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
