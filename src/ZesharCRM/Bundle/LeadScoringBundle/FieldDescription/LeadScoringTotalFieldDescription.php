<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\FieldDescription;

use ZesharCRM\Bundle\LeadScoringBundle\Entity\LeadScoring;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

class LeadScoringTotalFieldDescription extends FieldDescription
{
 
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'leadScoringTotal';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getValue($lead)
    {
        $em = $this->getAdmin()->getModelManager()->getEntityManager('ZesharCRM\Bundle\LeadScoringBundle\Entity\LeadScoring');
        $repository = $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring');
        $leadScoring = $repository->getLeadScoringByLead($lead);
        if (!is_null($leadScoring) && $leadScoring instanceof LeadScoring) {
            return $leadScoring->getTotal();
        } else {
            return NULL;
        }
    }
    
}
