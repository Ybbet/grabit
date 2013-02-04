<?php

namespace Grabit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', 'repeated', array(
		'type' => 'password',
		'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
		'options' => array('attr' => array('class' => 'password-field')),
		'required' => true,
		'first_options'  => array('label' => 'Mot de passe'),
		'second_options' => array('label' => 'Répétez le mot de passe')
	    ))
            ->add('bloque', 'hidden', array(
		'data' => 0
	    ))
	    ->add('id_utilisateur', 'hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Grabit\AdminBundle\Entity\Acces',
	    'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'grabit_adminbundle_accestype';
    }
}
