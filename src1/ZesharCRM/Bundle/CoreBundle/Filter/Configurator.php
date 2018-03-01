<?php

namespace ZesharCRM\Bundle\CoreBundle\Filter;

use Doctrine\Common\Persistence\ObjectManager;  
use Symfony\Component\Security\Core\SecurityContextInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\User;

class Configurator  
{

    protected $em;
    protected $securityContext;

    public function __construct(ObjectManager $em, SecurityContextInterface $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function onKernelRequest($event)
    {
        if ($this->securityContext->getToken() && $user = $this->securityContext->getToken()->getUser()) {
            if ($user instanceof User) {
                $filter = $this->em->getFilters()->enable('access_filter');
                $filter->setParameter('user_id', $user->getId());

                if (!$this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
                    $filter->setParameter('filter', true);
                }
            }
        }
    }
}