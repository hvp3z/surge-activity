<?php

namespace ZesharCRM\Bundle\CoreBundle\Menu;

use ZesharCRM\Bundle\CoreBundle\Event\ConfigureMenuEvent;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;

class MenuBuilder
{
    private $factory;
    private $container;
    private $items = array();

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(Container $container, FactoryInterface $factory)
    {
        $this->container = $container;
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        if ($this->container->get('security.context')->getToken()) {
            $user = $this->container->get('security.context')->getToken()->getUser();
        } else {
            $user = 'anon.';
        }

            $menu = $this->factory->createItem('root', array(
                'childrenAttributes'    => array(
                    'class'             => 'foo',
                ),
            ));
            if (is_object($user) && in_array('ROLE_DISABLED_ADMIN', $user->getRoles())) {
                //$menu->addChild('Dashboard', array('uri' => $request->getBaseUrl() . '/dashboard'));
                $menu->addChild('Payment Update', array('uri' => $this->container->get('router')->generate('account_show', array('id' => $user->getId()))));
            }
            elseif (is_object($user) && in_array('ROLE_ULTRA_ADMIN', $user->getRoles())) {
                $companyAdmin = $this->container->get('zeshar_crm_core.admin.company');
                /*$menu->addChild('Dashboard', array('uri' => $request->getBaseUrl() . '/dashboard'));
                $menu->addChild('Companies', array('uri' => $companyAdmin->generateUrl('list')));
                $menu->addChild('Accounts', array('uri' => $this->container->get('router')->generate('account_create')));*/

				$this->items['accounts'] = $menu->addChild('Accounts');
				$this->items['accounts']->addChild('View accounts' , array('uri' => $companyAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
				$this->items['accounts']->addChild('Create accounts' , array('uri' => $this->container->get('router')->generate('account_create')))->setLinkAttribute('class', 'icon-link icon-1');

				$this->items['products'] = $menu->addChild('Products');
				$this->items['products']->addChild('Pricing' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');
				$this->items['products']->addChild('Create Products' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-1');
				$this->items['products']->addChild('Lead List' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');

				$this->items['leads'] = $menu->addChild('Lead Point');
                $this->buildLeadsSubmenu();
				$this->items['leads']->addChild('Import CSV – Leads', array('uri' => $this->container->get('router')->generate('import_csv')));


				$this->items['settings'] = $menu->addChild('Settings');
				$this->items['settings']->addChild('Create users' , array('uri' => $this->container->get('router')->generate('account_create')))->setLinkAttribute('class', 'icon-link icon-1');
				$this->items['settings']->addChild('Create/edit roles' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');
				$this->items['settings']->addChild('Product pricing' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');


            } elseif (is_object($user)) {
                // core menu items
                $menu->addChild('Dashboard', array('uri' => $request->getBaseUrl() . '/dashboard'));
                $this->items['activities'] = $menu->addChild('Activities');
                $this->buildActivitiesSubmenu();


                $this->items['opportunities'] = $menu->addChild('Opportunities', array('attributes' => array('style' => 'display:none')));
                $this->buildOpportunitiesSubmenu();


				$this->items['my_leads'] = $menu->addChild('My Leads');
                $this->buildMyLeadsSubmenu();

                $this->items['quotes'] = $menu->addChild('Quotes', array('attributes' => array('style' => 'display:none')));
                $this->buildQuotesSubmenu();

				$this->items['purchase_leads'] = $menu->addChild('Purchase Leads');

                $this->items['leads'] = $menu->addChild('Lead Point', array('attributes' => array('style' => 'display:none')));
                $this->buildLeadsSubmenu();


                $this->items['leads']->addChild('Import CSV – Leads', array('uri' => $this->container->get('router')->generate('import_csv')));
                $this->items['contacts'] = $menu->addChild('Contacts');
                $this->buildContactsSubmenu();
                $reportAdmin = $this->container->get('zeshar_crm_calls.admin.call_reporting');
                $this->items['contacts']->addChild('Log A Call', array('uri' => $reportAdmin->generateUrl('create')))->setLinkAttribute('class', 'icon-link icon-2');
                $this->items['Reports'] = $menu->addChild('Reports');
                //        $this->items['leadPoints'] = $menu->addChild('LeadPoint');
                //        $this->buildLeadPointsSubmenu($request->getBaseUrl());
                //$this->items['Calendar'] = $menu->addChild('Calendar');
                //$this->buildCalendarSubmenu();
                //$menu->addChild('Setup', array('uri' => '#'));
                //        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
                //            $menu->addChild('Book of Business', array('uri' => '#'));
                //        }
                //        $menu->addChild('Account Info', array('uri' => '#'));
                //        $menu->addChild('Help Center', array('uri' => '#'));
                //        $this->items['History'] = $this->items['Reports']->addChild('History');
                $this->buildSimpleSubmenu($this->items['Reports'],
                    'zeshar_crm_core.admin.operation',
                    'Change Log');
                $this->buildSimpleSubmenu($this->items['Reports'],
                    'zeshar_crm_core.admin.log',
                    'Login Log');
                $this->items['Reports']->addChild('Lead Contact History', array('uri' => $reportAdmin->generateUrl('list')));
                $this->items['Reports']->addChild(' Lead performance', array('uri' => $this->container->get('router')->generate('reports_user_performance')));
                // if super admin - add link to admin panel
                if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
                    $user = $this->container->get('security.context')->getToken()->getUser();
                    $billingInfo = $user->getBillingInfo();

                    $this->items['Reports']->addChild('Conversion Rates', array('uri' => $this->container->get('router')->generate('reports_user_conversion')));
                    $this->items['Admin'] = $menu->addChild('Admin', array('uri' => $request->getBaseUrl() . '/admin/dashboard'));

                    if ($billingInfo) {
                        $billingInfoId = $billingInfo[0]->getId();
                        $this->items['Admin']->addChild('Account Setting', array('uri' => $this->container->get('router')->generate('admin_billing_info_show', array('id' => $billingInfoId))))->setLinkAttribute('class', 'icon-link icon-2'); // $this->container->get('router')->generate('reports_user_conversion')
                    }

                    $this->buildAdminSubmenu($request->getBaseUrl());
                }

                // hook other bundles to add advanced menu items
                $this->container->get('event_dispatcher')->dispatch(ConfigureMenuEvent::getEventId(), new ConfigureMenuEvent($this->factory, $menu));
            }

        return $menu;
    }

    public function buildActivitiesSubmenu()
    {
        $activityAdmin = $this->container->get('zeshar_crm_core.admin.activity');
        $this->items['activities']->addChild('Activity Lead List' , array('uri' => $activityAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
        $activityAdmin = $this->container->get('zeshar_crm_core.admin.expiredactivity');
        $this->items['activities']->addChild('Expired Activity Lead List' , array('uri' => $activityAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');

    }

    public function buildAdminSubmenu($baseUrl)
    {
        $fetchCallback = function() {
            return array();
        };

        $leadAdmin = $this->container->get('zeshar_crm_core.admin.lead');
        $leadSourceAdmin = $this->container->get('zeshar_crm_core.admin.lead_source');
        //$leadCampaignAdmin = $this->container->get('zeshar_crm_core.admin.lead_campaign');
        $activityCampaignAdmin = $this->container->get('zeshar_crm_core.admin.activity');
		$this->items['Admin']->addChild('Lead Management', array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');
		$this->items['Admin']->addChild('User Management', array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');
		$this->items['Admin']->addChild('Accounts Management', array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2');


        // $this->items['Admin']->addChild('Import BoB');
//        $this->items['Admin']->addChild('Inactive Activities');
        // $this->items['Admin']->addChild('Admin panel – basic entities management');
//        $this->items['leadPoints']->addChild('View more leads', array('uri' => $leadAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
//        $this->items['leadRecycle'] = $this->items['leadPoints']->addChild('Recycle');
//        $this->items['leadRecycle']->addChild('Recycled Opportunities');
//        $this->items['leadRecycle']->addChild('Recycled Quotes');
//        $this->items['leadPoints']->addChild('Lead Source', array('uri' => $leadSourceAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
//        $this->items['leadPoints']->addChild('Lead Type', array('uri' => $activityCampaignAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
//        $this->items['leadPoints']->addChild('Add Activity', array('uri' => $activityCampaignAdmin->generateUrl('create')))->setLinkAttribute('class', 'icon-link icon-1');
//        $this->buildEntitiesSubmenu(
//            $this->items['leadPoints'],
//            'zeshar_crm_core.admin.lead',
//            $fetchCallback,
//            NULL,
//            'View more leads',
//            'Add new',
//            5,
//            false
//        );
    }

    /**
     * Helper to build entities-specific submenu based on entity type
     * @param \Knp\Menu\ItemInterface $rootItem Item where to add children
     * @param string $adminServiceId Entity admin service ID
     * @param callable $fetchCallback Callback to fetch entities for submenu - should return entities collection
     * @param callable $itemTitleCallback [OPTIONAL] Callback to format menu item title - the entity is passed into, a string should be returned; if omitted - string conversion will be used
     * @param string $listItemTitle [OPTIONAL] The title of the item to browse entities list
     * @param string $createItemTitle [OPTIONAL] The title of the item to create new entity
     * @param int $itemsLimit [OPTIONAL] Maximum count of submenu entity items
     */
    public function buildEntitiesSubmenu($rootItem, $adminServiceId, $fetchCallback, $itemTitleCallback = NULL, $listItemTitle = NULL, $createItemTitle = NULL, $itemsLimit = 5, $showLastEntities = true, $filter = null, $routeList = 'list')
    {
        if (!is_callable($fetchCallback)) {
            throw new \BadMethodCallException('Fetch callback must be callable.');
        }
        if (!is_callable($itemTitleCallback) && !is_null($itemTitleCallback)) {
            throw new \BadMethodCallException('Item title callback must be either callable or null.');
        }

        $entityAdmin = $this->container->get($adminServiceId);
        $router = $this->container->get('router');

        if ($showLastEntities) {
            if ($currentUser = $this->getCurrentLoggedInUser()) {
                if ($entities = $fetchCallback()) {
                    foreach ($entities as $entity) {
                        if ($itemsLimit <= 0) {
                            break;
                        }
                        $itemsLimit--;
                        $itemTitle = is_callable($itemTitleCallback) ? $itemTitleCallback($entity) : (string) $entity;
                        $itemUrl = $entityAdmin->generateObjectUrl('show', $entity);
                        $rootItem->addChild($itemTitle, array(
                            'uri' => $itemUrl,
                        ));
                    }
                } else {
                    $rootItem->addChild('No items available')->setLinkAttribute('class', 'disable');
                }
            }
        }

        if ($listItemTitle) {
            if ($filter) {
                $rootItem->addChild($listItemTitle, array('uri' => $entityAdmin->generateUrl($routeList, $filter)))->setLinkAttribute('class', 'icon-link icon-2');
            } else {
                $rootItem->addChild($listItemTitle, array('uri' => $entityAdmin->generateUrl($routeList)))->setLinkAttribute('class', 'icon-link icon-2');
            }
        }
        if ($createItemTitle) {
            $rootItem->addChild($createItemTitle, array('uri' => $entityAdmin->generateUrl('create')))->setLinkAttribute('class', 'icon-link icon-1');
        }
    }

    public function buildSimpleSubmenu($rootItem, $adminServiceId, $listItemTitle = NULL, $createItemTitle = NULL)
    {
        $entityAdmin = $this->container->get($adminServiceId);

        if ($listItemTitle) {
            $rootItem->addChild($listItemTitle, array('uri' => $entityAdmin->generateUrl('list')))->setLinkAttribute('class', 'icon-link icon-2');
        }
        if ($createItemTitle) {
            $rootItem->addChild($createItemTitle, array('uri' => $entityAdmin->generateUrl('create')))->setLinkAttribute('class', 'icon-link icon-1');
        }
    }

    private function buildLeadsSubmenu()
    {
        $fetchCallback = function() {
            if ($currentUser = $this->getCurrentLoggedInUser()) {
                return $this
                    ->container
                    ->get('doctrine')
                    ->getManager()
                    ->getRepository('ZesharCRMCoreBundle:Lead')
                    ->fetchLeadsByAssignee($currentUser);
            } else {
                return array();
            }
        };

        $itemTitleCallback = function($lead) {
            $itemTitle = $lead->getName();
            if ($contactCard = $lead->getContactCard()) {
                $firstName = $contactCard->getFirstName();
                $lastName = $contactCard->getLastName();
                if ($firstName || $lastName) {
                    $itemTitle .= ' - ';
                }
                if ($firstName) {
                    $itemTitle .= $firstName;
                }
                if ($lastName) {
                    $itemTitle .= ' ' . $lastName;
                }
            }
            return $itemTitle;
        };

        $this->buildEntitiesSubmenu(
            $this->items['leads'],
            'zeshar_crm_core.admin.lead',
            $fetchCallback,
            $itemTitleCallback,
            'Lead Pool',
            'Add New Lead',
            5,
            false,
            array(),
            'listLeads'
        );
    }


	private function buildMyLeadsSubmenu()
    {

		$this->items['my_leads']->addChild('New Leads - 10' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2')->setExtra('safe_label', true );
		$this->items['my_leads']->addChild('Recycled Leads - 20' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2')->setExtra('safe_label', true );
		$this->items['my_leads']->addChild('X-Sale Leads - 100' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2')->setExtra('safe_label', true );
		$this->items['my_leads']->addChild('Lead pool - 500' , array('uri' => 'http://symf.testingtls.com'))->setLinkAttribute('class', 'icon-link icon-2')->setExtra('safe_label', true );
		return;
        $fetchCallback = function() {
            if ($currentUser = $this->getCurrentLoggedInUser()) {
                return $this
                    ->container
                    ->get('doctrine')
                    ->getManager()
                    ->getRepository('ZesharCRMCoreBundle:Lead')
                    ->fetchLeadsByAssignee($currentUser);
            } else {
                return array();
            }
        };

        $itemTitleCallback = function($lead) {
            $itemTitle = $lead->getName();
            if ($contactCard = $lead->getContactCard()) {
                $firstName = $contactCard->getFirstName();
                $lastName = $contactCard->getLastName();
                if ($firstName || $lastName) {
                    $itemTitle .= ' - ';
                }
                if ($firstName) {
                    $itemTitle .= $firstName;
                }
                if ($lastName) {
                    $itemTitle .= ' ' . $lastName;
                }
            }
            return $itemTitle;
        };

        $this->buildEntitiesSubmenu(
            $this->items['my_leads'],
            'zeshar_crm_core.admin.lead',
            $fetchCallback,
            $itemTitleCallback,
            'Lead Pool',
            'Add New Lead',
            5,
            false,
            array(),
            'listLeads'
        );
    }

    private function buildOpportunitiesSubmenu()
    {
        $fetchCallback = function() {
            if ($currentUser = $this->getCurrentLoggedInUser()) {
                return $this
                    ->container
                    ->get('doctrine')
                    ->getManager()
                    ->getRepository('ZesharCRMCoreBundle:Opportunity')
                    ->fetchOpportunitiesByAssignee($currentUser);
            } else {
                return array();
            }
        };

        $itemTitleCallback = function($opportunity) {
            $itemTitle = array();
            if ($contactCard = $opportunity->getContactCard()) {
                $itemTitle[] = $contactCard->getFirstName();
                $itemTitle[] = $contactCard->getMiddleInitial();
                $itemTitle[] = $contactCard->getLastName();
            }
            return implode(' ', $itemTitle);
        };

        $this->buildEntitiesSubmenu(
                $this->items['opportunities'],
                'zeshar_crm_core.admin.opportunity',
                $fetchCallback,
                $itemTitleCallback,
                'View more opportunities',
                null,
                5,
                true,
                array(),
                'listOpportunity'
        );
    }

    private function buildQuotesSubmenu()
    {
        $fetchCallback = function() {
            if ($currentUser = $this->getCurrentLoggedInUser()) {
                return $this
                    ->container
                    ->get('doctrine')
                    ->getManager()
                    ->getRepository('ZesharCRMCoreBundle:Opportunity')
                    ->fetchQuotesByAssignee($currentUser, 5, $this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN'));
            } else {
                return array();
            }
        };

        $itemTitleCallback = function($opportunity) {
            $itemTitle = array();
            if ($contactCard = $opportunity->getContactCard()) {
                $itemTitle[] = $contactCard->getFirstName();
                $itemTitle[] = $contactCard->getMiddleInitial();
                $itemTitle[] = $contactCard->getLastName();
            }
            return implode(' ', $itemTitle);
        };

//        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
//           $filter =  array(
//               'filter[status][value]' => OpportunityStatus::PENDING_QUOTE,
//          //     'filter[isAchieve][value]' => true,
//           );
//        } else {
//            $filter = array();
//        }

        $this->buildEntitiesSubmenu(
                $this->items['quotes'],
                'zeshar_crm_core.admin.opportunity',
                $fetchCallback,
                $itemTitleCallback,
                'View more quotes',
                null,
                5,
                true,
                array(/*'filter[status][value]'=>5*/),
                'listQuote'
        );

        $this->buildEntitiesSubmenu(
                $this->items['quotes'],
                'zeshar_crm_core.admin.opportunity',
                $fetchCallback,
                $itemTitleCallback,
                'Sold quotes',
                null,
                5,
                true,
                array(/*'filter[status][value]'=>5*/),
                'SoldQuote'
        );
    }

    private function buildContactsSubmenu()
    {
        $fetchCallback = function() {
            return array();
        };

        $this->buildEntitiesSubmenu(
            $this->items['contacts'],
            'zeshar_crm_core.admin.contact_card',
            $fetchCallback,
            NULL,
            'Contact List',
            'Add new',
            5,
            false
        );
    }

    private function buildCalendarSubmenu()
    {
        $fetchCallback = function() {
            return array();
        };

        $this->buildEntitiesSubmenu(
            $this->items['contacts'],
            'zeshar_crm_core.admin.contact_card',
            $fetchCallback,
            NULL,
            'View more contact',
            'Add new',
            5,
            false
        );
    }

    private function getCurrentLoggedInUser()
    {
        return ( ($currentUser = $this->container->get('security.context')->getToken()->getUser() ) && (is_object($currentUser)) ) ? $currentUser : NULL;
    }

}
