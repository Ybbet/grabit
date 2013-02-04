<?php

namespace Grabit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SouscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

	$builder
	    ->add('id_utilisateur', 'hidden')
            ->add('id_abonnement')
            ->add('fin_validite', 'date', array(
		    'input'  => 'datetime',
		    'widget' => 'choice',
		));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Grabit\AdminBundle\Entity\Souscription'
        ));
    }

    public function getName()
    {
        return 'grabit_adminbundle_souscriptiontype';
    }
}
