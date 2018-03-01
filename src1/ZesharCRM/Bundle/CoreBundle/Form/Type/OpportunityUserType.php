<?php

namespace ZesharCRM\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OpportunityUserType extends AbstractType
{
    /**
     * Building form with form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles', 'choice',array('choices'=>array('ROLE_SALES_PERSON'=>'ROLE_SALES_PERSON','ROLE_AGENCY_OWNER'=>'ROLE_AGENCY_OWNER'),'multiple'=>true ))
            ->add('email')
            ->add('plainPassword', 'text', array(
                'required' => true
            ))
            ->add('locked', null, array('required' => false))
            ->add('enabled', null, array('required' => false))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'FOS\UserBundle\Entity\User',
        );
    }

    public function getName()
    {
        return 'OpportunityUserType';
    }
}