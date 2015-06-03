<?php

namespace DV\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('label' => 'Nombre de la Pagina'))
            ->add('contenido','redactor', array( 
                                            "redactor"=>"admin_pagina",
                                            'label' => 'Contenido'
                                            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DV\MainBundle\Entity\Pagina'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dv_mainbundle_pagina';
    }
}
