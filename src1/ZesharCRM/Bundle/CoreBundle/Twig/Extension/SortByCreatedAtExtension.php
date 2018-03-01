<?php

namespace ZesharCRM\Bundle\CoreBundle\Twig\Extension;

use ZesharCRM\Bundle\CoreBundle\Entity;

class SortByCreatedAtExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('SortByCreatedAt', array($this, 'SortByCreatedAtFilter')),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sort_by_created_at';
    }


    public function SortByCreatedAtFilter($collection)
    {
       // print_r($collection->first()->getAttachment()->getCreatedAt()->getTimestamp());die;
        $collection = usort($collection, function($a, $b){
            if($a->getAttachment()->getCreatedAt()->getTimestamp() > $b->getAttachment()->getCreatedAt()->getTimestamp()) {
                return false;
            } else {
                return true;
            }

        });
        return $collection;
    }
}