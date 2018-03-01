<?php

namespace ZesharCRM\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory;

class CustomEvent extends Event
{
    private $type;

    private $lead;

    private $redirectUrl;

    private $product;

    private $enable;

    private $token;

    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }


    public function getLead()
    {
        return $this->lead;
    }
    public function setLead(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct(LeadCategory $product)
    {
        $this->product = $product;
    }

    public function getEnable()
    {
        return $this->enable;
    }
    public function setEnable( $value = false)
    {
        $this->enable = $value;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function setToken( $value = false)
    {
        $this->token = $value;
    }
}