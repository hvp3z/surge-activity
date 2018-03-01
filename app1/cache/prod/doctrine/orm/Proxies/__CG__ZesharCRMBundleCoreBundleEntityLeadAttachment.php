<?php

namespace Proxies\__CG__\ZesharCRM\Bundle\CoreBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LeadAttachment extends \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'id', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'attachment', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'leadSubject');
        }

        return array('__isInitialized__', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'id', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'attachment', '' . "\0" . 'ZesharCRM\\Bundle\\CoreBundle\\Entity\\LeadAttachment' . "\0" . 'leadSubject');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LeadAttachment $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\Attachment $attachment = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAttachment', array($attachment));

        return parent::setAttachment($attachment);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttachment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttachment', array());

        return parent::getAttachment();
    }

    /**
     * {@inheritDoc}
     */
    public function setLeadSubject(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $leadSubject)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLeadSubject', array($leadSubject));

        return parent::setLeadSubject($leadSubject);
    }

    /**
     * {@inheritDoc}
     */
    public function getLead()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLead', array());

        return parent::getLead();
    }

    /**
     * {@inheritDoc}
     */
    public function setLead(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLead', array($lead));

        return parent::setLead($lead);
    }

    /**
     * {@inheritDoc}
     */
    public function getLeadSubject()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLeadSubject', array());

        return parent::getLeadSubject();
    }

    /**
     * {@inheritDoc}
     */
    public function addOpportunityAttachment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addOpportunityAttachment', array());

        return parent::addOpportunityAttachment();
    }

    /**
     * {@inheritDoc}
     */
    public function updateOpportunityAttachment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updateOpportunityAttachment', array());

        return parent::updateOpportunityAttachment();
    }

    /**
     * {@inheritDoc}
     */
    public function removeOpportunityAttachment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeOpportunityAttachment', array());

        return parent::removeOpportunityAttachment();
    }

}