<?php

/*
 * Redefine constants from base Sonata Boolean type to use 0 and 1 values instead of 1 and 2
 */

namespace ZesharCRM\Bundle\CoreBundle\Form\Type;

use Sonata\CoreBundle\Form\Type\BooleanType as BooleanType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SonataExBooleanType extends BooleanType
{
    
    const TYPE_YES = 1;
    const TYPE_NO = 0;
    
    /**
     * {@inheritDoc}
     */

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'catalogue' => 'SonataCoreBundle',
            'choices'   => array(
                self::TYPE_YES  => 'label_type_yes',
                self::TYPE_NO   => 'label_type_no'
            ),
            'transform' => false
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'sonata_type_boolean';
    }
    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'zesharcrm_sonata_ex_type_boolean';
    }
    
}
