<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // zeshar_crm_lead_scoring_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'zeshar_crm_lead_scoring_homepage')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\DefaultController::indexAction',));
        }

        // sonata_admin_scoring
        if ($pathinfo === '/admin/scoring') {
            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringAdminController::scoringAction',  '_route' => 'sonata_admin_scoring',);
        }

        // zeshar_crm_call
        if ($pathinfo === '/call') {
            return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingController::createAction',  '_route' => 'zeshar_crm_call',);
        }

        // zeshar_crm_goals_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'zeshar_crm_goals_homepage')), array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/a')) {
            // zeshar_crm_goals_users
            if (rtrim($pathinfo, '/') === '/admin/goals') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'zeshar_crm_goals_users');
                }

                return array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\GoalGlobalAdminController::showAdminGoalsAction',  '_route' => 'zeshar_crm_goals_users',);
            }

            // ajaxGoalAdmin
            if (0 === strpos($pathinfo, '/ajax/goal_global_admin') && preg_match('#^/ajax/goal_global_admin/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxGoalAdmin')), array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\GoalGlobalAdminController::indexAction',));
            }

            if (0 === strpos($pathinfo, '/admin/goals')) {
                // zeshar_crm_goal_users
                if (0 === strpos($pathinfo, '/admin/goals/goal') && preg_match('#^/admin/goals/goal/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'zeshar_crm_goal_users')), array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\GoalGlobalAdminController::showAdminGoalAction',));
                }

                // zeshar_crm_goal_report
                if ($pathinfo === '/admin/goals/report') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\GoalGlobalAdminController::showAdminGoalReportAction',  '_route' => 'zeshar_crm_goal_report',);
                }

            }

        }

        // zeshar_crm_leads_regeneration_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'zeshar_crm_leads_regeneration_homepage')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadsRegenerationBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/crosssell')) {
                // sonata_admin_crosssell
                if ($pathinfo === '/admin/crosssell') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadsRegenerationBundle\\Controller\\CrossSellAdminController::crossSellAction',  '_route' => 'sonata_admin_crosssell',);
                }

                // sonata_admin_crosssell_leadgenerate
                if ($pathinfo === '/admin/crosssell/leadgenerate') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadsRegenerationBundle\\Controller\\CrossSellAdminController::generateLeadAction',  '_route' => 'sonata_admin_crosssell_leadgenerate',);
                }

            }

            // sonata_admin_redirect
            if (rtrim($pathinfo, '/') === '/admin') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'sonata_admin_redirect');
                }

                return array (  '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::redirectAction',  'route' => 'sonata_admin_dashboard',  'permanent' => 'true',  '_route' => 'sonata_admin_redirect',);
            }

            // sonata_admin_dashboard
            if ($pathinfo === '/admin/dashboard') {
                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CoreController::dashboardAction',  '_route' => 'sonata_admin_dashboard',);
            }

            if (0 === strpos($pathinfo, '/admin/core')) {
                // sonata_admin_retrieve_form_element
                if ($pathinfo === '/admin/core/get-form-field-element') {
                    return array (  '_controller' => 'sonata.admin.controller.admin:retrieveFormFieldElementAction',  '_route' => 'sonata_admin_retrieve_form_element',);
                }

                // sonata_admin_append_form_element
                if ($pathinfo === '/admin/core/append-form-field-element') {
                    return array (  '_controller' => 'sonata.admin.controller.admin:appendFormFieldElementAction',  '_route' => 'sonata_admin_append_form_element',);
                }

                // sonata_admin_short_object_information
                if (0 === strpos($pathinfo, '/admin/core/get-short-object-description') && preg_match('#^/admin/core/get\\-short\\-object\\-description(?:\\.(?P<_format>html|json))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_admin_short_object_information')), array (  '_controller' => 'sonata.admin.controller.admin:getShortObjectDescriptionAction',  '_format' => 'html',));
                }

                // sonata_admin_set_object_field_value
                if ($pathinfo === '/admin/core/set-object-field-value') {
                    return array (  '_controller' => 'sonata.admin.controller.admin:setObjectFieldValueAction',  '_route' => 'sonata_admin_set_object_field_value',);
                }

            }

            // sonata_admin_search
            if ($pathinfo === '/admin/search') {
                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CoreController::searchAction',  '_route' => 'sonata_admin_search',);
            }

            // sonata_admin_retrieve_autocomplete_items
            if ($pathinfo === '/admin/core/get-autocomplete-items') {
                return array (  '_controller' => 'sonata.admin.controller.admin:retrieveAutocompleteItemsAction',  '_route' => 'sonata_admin_retrieve_autocomplete_items',);
            }

            if (0 === strpos($pathinfo, '/admin/activity')) {
                // admin_activity_list
                if ($pathinfo === '/admin/activity/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_list',  '_route' => 'admin_activity_list',);
                }

                // admin_activity_create
                if ($pathinfo === '/admin/activity/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_create',  '_route' => 'admin_activity_create',);
                }

                // admin_activity_batch
                if ($pathinfo === '/admin/activity/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_batch',  '_route' => 'admin_activity_batch',);
                }

                // admin_activity_edit
                if (preg_match('#^/admin/activity/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_activity_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_edit',));
                }

                // admin_activity_delete
                if (preg_match('#^/admin/activity/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_activity_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_delete',));
                }

                // admin_activity_show
                if (preg_match('#^/admin/activity/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_activity_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_show',));
                }

                // admin_activity_export
                if ($pathinfo === '/admin/activity/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_export',  '_route' => 'admin_activity_export',);
                }

                // admin_activity_closeActivity
                if (preg_match('#^/admin/activity/(?P<id>[^/]++)/close_activity$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_activity_closeActivity')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::closeActivityAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_closeActivity',));
                }

                // admin_activity_listShow
                if ($pathinfo === '/admin/activity/listShow') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityCRUDController::listShowAction',  '_sonata_admin' => 'zeshar_crm_core.admin.activity',  '_sonata_name' => 'admin_activity_listShow',  '_route' => 'admin_activity_listShow',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/company')) {
                // admin_company_list
                if ($pathinfo === '/admin/company/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_list',  '_route' => 'admin_company_list',);
                }

                // admin_company_batch
                if ($pathinfo === '/admin/company/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_batch',  '_route' => 'admin_company_batch',);
                }

                // admin_company_edit
                if (preg_match('#^/admin/company/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_company_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_edit',));
                }

                // admin_company_delete
                if (preg_match('#^/admin/company/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_company_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_delete',));
                }

                // admin_company_show
                if (preg_match('#^/admin/company/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_company_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_show',));
                }

                // admin_company_export
                if ($pathinfo === '/admin/company/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CompanyCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.company',  '_sonata_name' => 'admin_company_export',  '_route' => 'admin_company_export',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/account')) {
                // account_list
                if ($pathinfo === '/admin/account/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_list',  '_route' => 'account_list',);
                }

                // account_create
                if ($pathinfo === '/admin/account/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_create',  '_route' => 'account_create',);
                }

                // account_batch
                if ($pathinfo === '/admin/account/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_batch',  '_route' => 'account_batch',);
                }

                // account_edit
                if (preg_match('#^/admin/account/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'account_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_edit',));
                }

                // account_delete
                if (preg_match('#^/admin/account/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'account_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_delete',));
                }

                // account_show
                if (preg_match('#^/admin/account/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'account_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_show',));
                }

                // account_export
                if ($pathinfo === '/admin/account/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.account',  '_sonata_name' => 'account_export',  '_route' => 'account_export',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/expiredactivity')) {
                // admin_expiredactivity_list
                if ($pathinfo === '/admin/expiredactivity/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ExpiredActivityCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.expiredactivity',  '_sonata_name' => 'admin_expiredactivity_list',  '_route' => 'admin_expiredactivity_list',);
                }

                // admin_expiredactivity_closeActivity
                if (preg_match('#^/admin/expiredactivity/(?P<id>[^/]++)/close_activity$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_expiredactivity_closeActivity')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ExpiredActivityCRUDController::closeActivityAction',  '_sonata_admin' => 'zeshar_crm_core.admin.expiredactivity',  '_sonata_name' => 'admin_expiredactivity_closeActivity',));
                }

                // admin_expiredactivity_export
                if ($pathinfo === '/admin/expiredactivity/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ExpiredActivityCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.expiredactivity',  '_sonata_name' => 'admin_expiredactivity_export',  '_route' => 'admin_expiredactivity_export',);
                }

                // admin_expiredactivity_batch
                if ($pathinfo === '/admin/expiredactivity/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ExpiredActivityCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.expiredactivity',  '_sonata_name' => 'admin_expiredactivity_batch',  '_route' => 'admin_expiredactivity_batch',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/zesharcrm/core/opportunity')) {
                // admin_zesharcrm_core_opportunity_list
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/listOpportunity') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_list',  '_route' => 'admin_zesharcrm_core_opportunity_list',);
                }

                // admin_zesharcrm_core_opportunity_create
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_create',  '_route' => 'admin_zesharcrm_core_opportunity_create',);
                }

                // admin_zesharcrm_core_opportunity_batch
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_batch',  '_route' => 'admin_zesharcrm_core_opportunity_batch',);
                }

                // admin_zesharcrm_core_opportunity_edit
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_edit',));
                }

                // admin_zesharcrm_core_opportunity_delete
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_delete',));
                }

                // admin_zesharcrm_core_opportunity_show
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_show',));
                }

                // admin_zesharcrm_core_opportunity_export
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_export',  '_route' => 'admin_zesharcrm_core_opportunity_export',);
                }

                // admin_zesharcrm_core_opportunity_closeOpportunity
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/close_opportunity$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_closeOpportunity')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::closeOpportunityAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_closeOpportunity',));
                }

                // admin_zesharcrm_core_opportunity_cancelOpportunity
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/cancel_opportunity$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_cancelOpportunity')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::cancelOpportunityAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_cancelOpportunity',));
                }

                // admin_zesharcrm_core_opportunity_closeQuote
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/close_quote$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_closeQuote')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::closeQuoteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_closeQuote',));
                }

                // admin_zesharcrm_core_opportunity_cancelQuote
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<id>[^/]++)/cancel_quote$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_cancelQuote')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::cancelQuoteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_cancelQuote',));
                }

                // admin_zesharcrm_core_opportunity_update
                if (preg_match('#^/admin/zesharcrm/core/opportunity/(?P<opportunity>[^/]++)/update$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunity_update')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::updateAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_update',));
                }

                // admin_zesharcrm_core_opportunity_listQuote
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/listQuote') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::listQuoteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_listQuote',  '_route' => 'admin_zesharcrm_core_opportunity_listQuote',);
                }

                // admin_zesharcrm_core_opportunity_SoldQuote
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/SoldQuote') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::soldQuoteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_SoldQuote',  '_route' => 'admin_zesharcrm_core_opportunity_SoldQuote',);
                }

                // admin_zesharcrm_core_opportunity_listOpportunity
                if ($pathinfo === '/admin/zesharcrm/core/opportunity/listOpportunity') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\OpportunityCRUDController::listOpportunityAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity',  '_sonata_name' => 'admin_zesharcrm_core_opportunity_listOpportunity',  '_route' => 'admin_zesharcrm_core_opportunity_listOpportunity',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/billing_info')) {
                // admin_billing_info_list
                if ($pathinfo === '/admin/billing_info/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_list',  '_route' => 'admin_billing_info_list',);
                }

                // admin_billing_info_create
                if ($pathinfo === '/admin/billing_info/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_create',  '_route' => 'admin_billing_info_create',);
                }

                // admin_billing_info_batch
                if ($pathinfo === '/admin/billing_info/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_batch',  '_route' => 'admin_billing_info_batch',);
                }

                // admin_billing_info_edit
                if (preg_match('#^/admin/billing_info/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_billing_info_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_edit',));
                }

                // admin_billing_info_delete
                if (preg_match('#^/admin/billing_info/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_billing_info_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_delete',));
                }

                // admin_billing_info_show
                if (preg_match('#^/admin/billing_info/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_billing_info_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_show',));
                }

                // admin_billing_info_export
                if ($pathinfo === '/admin/billing_info/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.billinginfo',  '_sonata_name' => 'admin_billing_info_export',  '_route' => 'admin_billing_info_export',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/payment_history')) {
                // admin_payment_history_list
                if ($pathinfo === '/admin/payment_history/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_list',  '_route' => 'admin_payment_history_list',);
                }

                // admin_payment_history_create
                if ($pathinfo === '/admin/payment_history/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_create',  '_route' => 'admin_payment_history_create',);
                }

                // admin_payment_history_batch
                if ($pathinfo === '/admin/payment_history/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_batch',  '_route' => 'admin_payment_history_batch',);
                }

                // admin_payment_history_edit
                if (preg_match('#^/admin/payment_history/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_payment_history_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_edit',));
                }

                // admin_payment_history_delete
                if (preg_match('#^/admin/payment_history/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_payment_history_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_delete',));
                }

                // admin_payment_history_show
                if (preg_match('#^/admin/payment_history/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_payment_history_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_show',));
                }

                // admin_payment_history_export
                if ($pathinfo === '/admin/payment_history/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\PaymentsCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.payments',  '_sonata_name' => 'admin_payment_history_export',  '_route' => 'admin_payment_history_export',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/zesharcrm/core')) {
                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/lead')) {
                    // admin_zesharcrm_core_lead_list
                    if ($pathinfo === '/admin/zesharcrm/core/lead/list') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_list',  '_route' => 'admin_zesharcrm_core_lead_list',);
                    }

                    // admin_zesharcrm_core_lead_create
                    if ($pathinfo === '/admin/zesharcrm/core/lead/create') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_create',  '_route' => 'admin_zesharcrm_core_lead_create',);
                    }

                    // admin_zesharcrm_core_lead_batch
                    if ($pathinfo === '/admin/zesharcrm/core/lead/batch') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_batch',  '_route' => 'admin_zesharcrm_core_lead_batch',);
                    }

                    // admin_zesharcrm_core_lead_edit
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_edit',));
                    }

                    // admin_zesharcrm_core_lead_delete
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_delete',));
                    }

                    // admin_zesharcrm_core_lead_show
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_show',));
                    }

                    // admin_zesharcrm_core_lead_export
                    if ($pathinfo === '/admin/zesharcrm/core/lead/export') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_export',  '_route' => 'admin_zesharcrm_core_lead_export',);
                    }

                    // admin_zesharcrm_core_lead_close
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/close$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_close')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::closeAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_close',));
                    }

                    // admin_zesharcrm_core_lead_cancel
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/cancel$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_cancel')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::cancelAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_cancel',));
                    }

                    // admin_zesharcrm_core_lead_reopen
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/reopen$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_reopen')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::reopenAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_reopen',));
                    }

                    // admin_zesharcrm_core_lead_warmup
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<id>[^/]++)/warmup$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_warmup')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::warmupAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_warmup',));
                    }

                    // admin_zesharcrm_core_lead_update
                    if (preg_match('#^/admin/zesharcrm/core/lead/(?P<lead>[^/]++)/update$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_lead_update')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::updateAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_update',));
                    }

                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/lead/list')) {
                        // admin_zesharcrm_core_lead_listLeads
                        if ($pathinfo === '/admin/zesharcrm/core/lead/listLeads') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::listLeadsAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_listLeads',  '_route' => 'admin_zesharcrm_core_lead_listLeads',);
                        }

                        // admin_zesharcrm_core_lead_listDeleted
                        if ($pathinfo === '/admin/zesharcrm/core/lead/listDeleted') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadsCRUDController::listDeletedAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead',  '_sonata_name' => 'admin_zesharcrm_core_lead_listDeleted',  '_route' => 'admin_zesharcrm_core_lead_listDeleted',);
                        }

                    }

                    // admin_zesharcrm_core_leadsubject_list
                    if ($pathinfo === '/admin/zesharcrm/core/leadsubject/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.leadsubject',  '_sonata_name' => 'admin_zesharcrm_core_leadsubject_list',  '_route' => 'admin_zesharcrm_core_leadsubject_list',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/contact')) {
                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/contactcard')) {
                        // admin_zesharcrm_core_contactcard_list
                        if ($pathinfo === '/admin/zesharcrm/core/contactcard/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_list',  '_route' => 'admin_zesharcrm_core_contactcard_list',);
                        }

                        // admin_zesharcrm_core_contactcard_create
                        if ($pathinfo === '/admin/zesharcrm/core/contactcard/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_create',  '_route' => 'admin_zesharcrm_core_contactcard_create',);
                        }

                        // admin_zesharcrm_core_contactcard_batch
                        if ($pathinfo === '/admin/zesharcrm/core/contactcard/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_batch',  '_route' => 'admin_zesharcrm_core_contactcard_batch',);
                        }

                        // admin_zesharcrm_core_contactcard_edit
                        if (preg_match('#^/admin/zesharcrm/core/contactcard/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contactcard_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_edit',));
                        }

                        // admin_zesharcrm_core_contactcard_delete
                        if (preg_match('#^/admin/zesharcrm/core/contactcard/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contactcard_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_delete',));
                        }

                        // admin_zesharcrm_core_contactcard_show
                        if (preg_match('#^/admin/zesharcrm/core/contactcard/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contactcard_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_show',));
                        }

                        // admin_zesharcrm_core_contactcard_export
                        if ($pathinfo === '/admin/zesharcrm/core/contactcard/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_export',  '_route' => 'admin_zesharcrm_core_contactcard_export',);
                        }

                        // admin_zesharcrm_core_contactcard_winBackQuote
                        if (preg_match('#^/admin/zesharcrm/core/contactcard/(?P<id>[^/]++)/win_back$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contactcard_winBackQuote')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ContactCardCRUDController::winBackQuoteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact_card',  '_sonata_name' => 'admin_zesharcrm_core_contactcard_winBackQuote',));
                        }

                    }

                    // admin_zesharcrm_core_contact_list
                    if ($pathinfo === '/admin/zesharcrm/core/contact/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_list',  '_route' => 'admin_zesharcrm_core_contact_list',);
                    }

                    // admin_zesharcrm_core_contact_create
                    if ($pathinfo === '/admin/zesharcrm/core/contact/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_create',  '_route' => 'admin_zesharcrm_core_contact_create',);
                    }

                    // admin_zesharcrm_core_contact_batch
                    if ($pathinfo === '/admin/zesharcrm/core/contact/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_batch',  '_route' => 'admin_zesharcrm_core_contact_batch',);
                    }

                    // admin_zesharcrm_core_contact_edit
                    if (preg_match('#^/admin/zesharcrm/core/contact/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contact_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_edit',));
                    }

                    // admin_zesharcrm_core_contact_delete
                    if (preg_match('#^/admin/zesharcrm/core/contact/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contact_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_delete',));
                    }

                    // admin_zesharcrm_core_contact_show
                    if (preg_match('#^/admin/zesharcrm/core/contact/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_contact_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_show',));
                    }

                    // admin_zesharcrm_core_contact_export
                    if ($pathinfo === '/admin/zesharcrm/core/contact/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.contact',  '_sonata_name' => 'admin_zesharcrm_core_contact_export',  '_route' => 'admin_zesharcrm_core_contact_export',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/lead')) {
                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/leadeventtype')) {
                        // admin_zesharcrm_core_leadeventtype_list
                        if ($pathinfo === '/admin/zesharcrm/core/leadeventtype/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_list',  '_route' => 'admin_zesharcrm_core_leadeventtype_list',);
                        }

                        // admin_zesharcrm_core_leadeventtype_create
                        if ($pathinfo === '/admin/zesharcrm/core/leadeventtype/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_create',  '_route' => 'admin_zesharcrm_core_leadeventtype_create',);
                        }

                        // admin_zesharcrm_core_leadeventtype_batch
                        if ($pathinfo === '/admin/zesharcrm/core/leadeventtype/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_batch',  '_route' => 'admin_zesharcrm_core_leadeventtype_batch',);
                        }

                        // admin_zesharcrm_core_leadeventtype_edit
                        if (preg_match('#^/admin/zesharcrm/core/leadeventtype/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadeventtype_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_edit',));
                        }

                        // admin_zesharcrm_core_leadeventtype_delete
                        if (preg_match('#^/admin/zesharcrm/core/leadeventtype/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadeventtype_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_delete',));
                        }

                        // admin_zesharcrm_core_leadeventtype_show
                        if (preg_match('#^/admin/zesharcrm/core/leadeventtype/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadeventtype_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_show',));
                        }

                        // admin_zesharcrm_core_leadeventtype_export
                        if ($pathinfo === '/admin/zesharcrm/core/leadeventtype/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadEventTypeCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_event_type',  '_sonata_name' => 'admin_zesharcrm_core_leadeventtype_export',  '_route' => 'admin_zesharcrm_core_leadeventtype_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/leadtype')) {
                        // admin_zesharcrm_core_leadtype_list
                        if ($pathinfo === '/admin/zesharcrm/core/leadtype/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_list',  '_route' => 'admin_zesharcrm_core_leadtype_list',);
                        }

                        // admin_zesharcrm_core_leadtype_create
                        if ($pathinfo === '/admin/zesharcrm/core/leadtype/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_create',  '_route' => 'admin_zesharcrm_core_leadtype_create',);
                        }

                        // admin_zesharcrm_core_leadtype_batch
                        if ($pathinfo === '/admin/zesharcrm/core/leadtype/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_batch',  '_route' => 'admin_zesharcrm_core_leadtype_batch',);
                        }

                        // admin_zesharcrm_core_leadtype_edit
                        if (preg_match('#^/admin/zesharcrm/core/leadtype/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadtype_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_edit',));
                        }

                        // admin_zesharcrm_core_leadtype_delete
                        if (preg_match('#^/admin/zesharcrm/core/leadtype/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadtype_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_delete',));
                        }

                        // admin_zesharcrm_core_leadtype_show
                        if (preg_match('#^/admin/zesharcrm/core/leadtype/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadtype_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_show',));
                        }

                        // admin_zesharcrm_core_leadtype_export
                        if ($pathinfo === '/admin/zesharcrm/core/leadtype/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadTypeCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_type',  '_sonata_name' => 'admin_zesharcrm_core_leadtype_export',  '_route' => 'admin_zesharcrm_core_leadtype_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/leadcategory')) {
                        // admin_zesharcrm_core_leadcategory_list
                        if ($pathinfo === '/admin/zesharcrm/core/leadcategory/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_list',  '_route' => 'admin_zesharcrm_core_leadcategory_list',);
                        }

                        // admin_zesharcrm_core_leadcategory_create
                        if ($pathinfo === '/admin/zesharcrm/core/leadcategory/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_create',  '_route' => 'admin_zesharcrm_core_leadcategory_create',);
                        }

                        // admin_zesharcrm_core_leadcategory_batch
                        if ($pathinfo === '/admin/zesharcrm/core/leadcategory/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_batch',  '_route' => 'admin_zesharcrm_core_leadcategory_batch',);
                        }

                        // admin_zesharcrm_core_leadcategory_edit
                        if (preg_match('#^/admin/zesharcrm/core/leadcategory/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadcategory_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_edit',));
                        }

                        // admin_zesharcrm_core_leadcategory_delete
                        if (preg_match('#^/admin/zesharcrm/core/leadcategory/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadcategory_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_delete',));
                        }

                        // admin_zesharcrm_core_leadcategory_show
                        if (preg_match('#^/admin/zesharcrm/core/leadcategory/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadcategory_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_show',));
                        }

                        // admin_zesharcrm_core_leadcategory_export
                        if ($pathinfo === '/admin/zesharcrm/core/leadcategory/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadCategoryCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_category',  '_sonata_name' => 'admin_zesharcrm_core_leadcategory_export',  '_route' => 'admin_zesharcrm_core_leadcategory_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/zesharcrm/core/leadsource')) {
                        // admin_zesharcrm_core_leadsource_list
                        if ($pathinfo === '/admin/zesharcrm/core/leadsource/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_list',  '_route' => 'admin_zesharcrm_core_leadsource_list',);
                        }

                        // admin_zesharcrm_core_leadsource_create
                        if ($pathinfo === '/admin/zesharcrm/core/leadsource/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_create',  '_route' => 'admin_zesharcrm_core_leadsource_create',);
                        }

                        // admin_zesharcrm_core_leadsource_batch
                        if ($pathinfo === '/admin/zesharcrm/core/leadsource/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_batch',  '_route' => 'admin_zesharcrm_core_leadsource_batch',);
                        }

                        // admin_zesharcrm_core_leadsource_edit
                        if (preg_match('#^/admin/zesharcrm/core/leadsource/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadsource_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_edit',));
                        }

                        // admin_zesharcrm_core_leadsource_delete
                        if (preg_match('#^/admin/zesharcrm/core/leadsource/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadsource_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_delete',));
                        }

                        // admin_zesharcrm_core_leadsource_show
                        if (preg_match('#^/admin/zesharcrm/core/leadsource/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadsource_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_show',));
                        }

                        // admin_zesharcrm_core_leadsource_export
                        if ($pathinfo === '/admin/zesharcrm/core/leadsource/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadSourceCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_source',  '_sonata_name' => 'admin_zesharcrm_core_leadsource_export',  '_route' => 'admin_zesharcrm_core_leadsource_export',);
                        }

                    }

                }

                // admin_zesharcrm_core_operation_list
                if ($pathinfo === '/admin/zesharcrm/core/operation/list') {
                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.operation',  '_sonata_name' => 'admin_zesharcrm_core_operation_list',  '_route' => 'admin_zesharcrm_core_operation_list',);
                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/leadattachment')) {
                    // admin_zesharcrm_core_leadattachment_list
                    if ($pathinfo === '/admin/zesharcrm/core/leadattachment/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_list',  '_route' => 'admin_zesharcrm_core_leadattachment_list',);
                    }

                    // admin_zesharcrm_core_leadattachment_create
                    if ($pathinfo === '/admin/zesharcrm/core/leadattachment/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_create',  '_route' => 'admin_zesharcrm_core_leadattachment_create',);
                    }

                    // admin_zesharcrm_core_leadattachment_batch
                    if ($pathinfo === '/admin/zesharcrm/core/leadattachment/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_batch',  '_route' => 'admin_zesharcrm_core_leadattachment_batch',);
                    }

                    // admin_zesharcrm_core_leadattachment_edit
                    if (preg_match('#^/admin/zesharcrm/core/leadattachment/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadattachment_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_edit',));
                    }

                    // admin_zesharcrm_core_leadattachment_delete
                    if (preg_match('#^/admin/zesharcrm/core/leadattachment/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadattachment_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_delete',));
                    }

                    // admin_zesharcrm_core_leadattachment_show
                    if (preg_match('#^/admin/zesharcrm/core/leadattachment/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_leadattachment_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_show',));
                    }

                    // admin_zesharcrm_core_leadattachment_export
                    if ($pathinfo === '/admin/zesharcrm/core/leadattachment/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.lead_attachment',  '_sonata_name' => 'admin_zesharcrm_core_leadattachment_export',  '_route' => 'admin_zesharcrm_core_leadattachment_export',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/opportunityattachment')) {
                    // admin_zesharcrm_core_opportunityattachment_list
                    if ($pathinfo === '/admin/zesharcrm/core/opportunityattachment/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_list',  '_route' => 'admin_zesharcrm_core_opportunityattachment_list',);
                    }

                    // admin_zesharcrm_core_opportunityattachment_create
                    if ($pathinfo === '/admin/zesharcrm/core/opportunityattachment/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_create',  '_route' => 'admin_zesharcrm_core_opportunityattachment_create',);
                    }

                    // admin_zesharcrm_core_opportunityattachment_batch
                    if ($pathinfo === '/admin/zesharcrm/core/opportunityattachment/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_batch',  '_route' => 'admin_zesharcrm_core_opportunityattachment_batch',);
                    }

                    // admin_zesharcrm_core_opportunityattachment_edit
                    if (preg_match('#^/admin/zesharcrm/core/opportunityattachment/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunityattachment_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_edit',));
                    }

                    // admin_zesharcrm_core_opportunityattachment_delete
                    if (preg_match('#^/admin/zesharcrm/core/opportunityattachment/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunityattachment_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_delete',));
                    }

                    // admin_zesharcrm_core_opportunityattachment_show
                    if (preg_match('#^/admin/zesharcrm/core/opportunityattachment/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_opportunityattachment_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_show',));
                    }

                    // admin_zesharcrm_core_opportunityattachment_export
                    if ($pathinfo === '/admin/zesharcrm/core/opportunityattachment/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.opportunity_attachment',  '_sonata_name' => 'admin_zesharcrm_core_opportunityattachment_export',  '_route' => 'admin_zesharcrm_core_opportunityattachment_export',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/core/attachment')) {
                    // admin_zesharcrm_core_attachment_list
                    if ($pathinfo === '/admin/zesharcrm/core/attachment/list') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_list',  '_route' => 'admin_zesharcrm_core_attachment_list',);
                    }

                    // admin_zesharcrm_core_attachment_create
                    if ($pathinfo === '/admin/zesharcrm/core/attachment/create') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::createAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_create',  '_route' => 'admin_zesharcrm_core_attachment_create',);
                    }

                    // admin_zesharcrm_core_attachment_batch
                    if ($pathinfo === '/admin/zesharcrm/core/attachment/batch') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::batchAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_batch',  '_route' => 'admin_zesharcrm_core_attachment_batch',);
                    }

                    // admin_zesharcrm_core_attachment_edit
                    if (preg_match('#^/admin/zesharcrm/core/attachment/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_attachment_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::editAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_edit',));
                    }

                    // admin_zesharcrm_core_attachment_delete
                    if (preg_match('#^/admin/zesharcrm/core/attachment/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_attachment_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::deleteAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_delete',));
                    }

                    // admin_zesharcrm_core_attachment_show
                    if (preg_match('#^/admin/zesharcrm/core/attachment/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_core_attachment_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::showAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_show',));
                    }

                    // admin_zesharcrm_core_attachment_export
                    if ($pathinfo === '/admin/zesharcrm/core/attachment/export') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AttachmentsCRUDController::exportAction',  '_sonata_admin' => 'zeshar_crm_core.admin.attachment',  '_sonata_name' => 'admin_zesharcrm_core_attachment_export',  '_route' => 'admin_zesharcrm_core_attachment_export',);
                    }

                }

                // admin_zesharcrm_core_log_list
                if ($pathinfo === '/admin/zesharcrm/core/log/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LogAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_core.admin.log',  '_sonata_name' => 'admin_zesharcrm_core_log_list',  '_route' => 'admin_zesharcrm_core_log_list',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/user')) {
                // admin_user_list
                if ($pathinfo === '/admin/user/list') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::listAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_list',  '_route' => 'admin_user_list',);
                }

                // admin_user_create
                if ($pathinfo === '/admin/user/create') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::createAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_create',  '_route' => 'admin_user_create',);
                }

                // admin_user_batch
                if ($pathinfo === '/admin/user/batch') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::batchAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_batch',  '_route' => 'admin_user_batch',);
                }

                // admin_user_edit
                if (preg_match('#^/admin/user/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_user_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::editAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_edit',));
                }

                // admin_user_delete
                if (preg_match('#^/admin/user/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_user_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::deleteAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_delete',));
                }

                // admin_user_show
                if (preg_match('#^/admin/user/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_user_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::showAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_show',));
                }

                // admin_user_export
                if ($pathinfo === '/admin/user/export') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\UserCRUDController::exportAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_user_export',  '_route' => 'admin_user_export',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/zesharcrm')) {
                if (0 === strpos($pathinfo, '/admin/zesharcrm/leadsregeneration/leadsregeneration')) {
                    // admin_zesharcrm_leadsregeneration_leadsregeneration_list
                    if ($pathinfo === '/admin/zesharcrm/leadsregeneration/leadsregeneration/list') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadsRegenerationBundle\\Controller\\LeadsRegenerationAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_leads_regeneration.admin.leads_regeneration',  '_sonata_name' => 'admin_zesharcrm_leadsregeneration_leadsregeneration_list',  '_route' => 'admin_zesharcrm_leadsregeneration_leadsregeneration_list',);
                    }

                    // admin_zesharcrm_leadsregeneration_leadsregeneration_edit
                    if (preg_match('#^/admin/zesharcrm/leadsregeneration/leadsregeneration/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadsregeneration_leadsregeneration_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadsRegenerationBundle\\Controller\\LeadsRegenerationAdminController::editAction',  '_sonata_admin' => 'zeshar_crm_leads_regeneration.admin.leads_regeneration',  '_sonata_name' => 'admin_zesharcrm_leadsregeneration_leadsregeneration_edit',));
                    }

                }

                // admin_zesharcrm_goals_goal_list
                if ($pathinfo === '/admin/zesharcrm/goals/goal/../../../goals') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\GoalsBundle\\Controller\\GoalAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_goals.admin.goal',  '_sonata_name' => 'admin_zesharcrm_goals_goal_list',  '_route' => 'admin_zesharcrm_goals_goal_list',);
                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/calls/callreporting')) {
                    // admin_zesharcrm_calls_callreporting_list
                    if ($pathinfo === '/admin/zesharcrm/calls/callreporting/list') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_list',  '_route' => 'admin_zesharcrm_calls_callreporting_list',);
                    }

                    // admin_zesharcrm_calls_callreporting_create
                    if ($pathinfo === '/admin/zesharcrm/calls/callreporting/create') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::createAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_create',  '_route' => 'admin_zesharcrm_calls_callreporting_create',);
                    }

                    // admin_zesharcrm_calls_callreporting_batch
                    if ($pathinfo === '/admin/zesharcrm/calls/callreporting/batch') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::batchAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_batch',  '_route' => 'admin_zesharcrm_calls_callreporting_batch',);
                    }

                    // admin_zesharcrm_calls_callreporting_edit
                    if (preg_match('#^/admin/zesharcrm/calls/callreporting/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_calls_callreporting_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::editAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_edit',));
                    }

                    // admin_zesharcrm_calls_callreporting_delete
                    if (preg_match('#^/admin/zesharcrm/calls/callreporting/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_calls_callreporting_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::deleteAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_delete',));
                    }

                    // admin_zesharcrm_calls_callreporting_show
                    if (preg_match('#^/admin/zesharcrm/calls/callreporting/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_calls_callreporting_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::showAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_show',));
                    }

                    // admin_zesharcrm_calls_callreporting_export
                    if ($pathinfo === '/admin/zesharcrm/calls/callreporting/export') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::exportAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_export',  '_route' => 'admin_zesharcrm_calls_callreporting_export',);
                    }

                    // admin_zesharcrm_calls_callreporting_listShow
                    if ($pathinfo === '/admin/zesharcrm/calls/callreporting/listShow') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CallsBundle\\Controller\\CallReportingAdminController::listShowAction',  '_sonata_admin' => 'zeshar_crm_calls.admin.call_reporting',  '_sonata_name' => 'admin_zesharcrm_calls_callreporting_listShow',  '_route' => 'admin_zesharcrm_calls_callreporting_listShow',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/zesharcrm/leadscoring')) {
                    if (0 === strpos($pathinfo, '/admin/zesharcrm/leadscoring/scoringcriteria')) {
                        // admin_zesharcrm_leadscoring_scoringcriteria_list
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/scoringcriteria/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_list',  '_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_list',);
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_create
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/scoringcriteria/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::createAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_create',  '_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_create',);
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_batch
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/scoringcriteria/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::batchAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_batch',  '_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_batch',);
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_edit
                        if (preg_match('#^/admin/zesharcrm/leadscoring/scoringcriteria/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::editAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_edit',));
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_delete
                        if (preg_match('#^/admin/zesharcrm/leadscoring/scoringcriteria/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::deleteAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_delete',));
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_show
                        if (preg_match('#^/admin/zesharcrm/leadscoring/scoringcriteria/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::showAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_show',));
                        }

                        // admin_zesharcrm_leadscoring_scoringcriteria_export
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/scoringcriteria/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\ScoringCriteriaAdminController::exportAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.scoring_criteria',  '_sonata_name' => 'admin_zesharcrm_leadscoring_scoringcriteria_export',  '_route' => 'admin_zesharcrm_leadscoring_scoringcriteria_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/zesharcrm/leadscoring/leadscoring')) {
                        // admin_zesharcrm_leadscoring_leadscoring_list
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/leadscoring/list') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::listAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_list',  '_route' => 'admin_zesharcrm_leadscoring_leadscoring_list',);
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_create
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/leadscoring/create') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::createAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_create',  '_route' => 'admin_zesharcrm_leadscoring_leadscoring_create',);
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_batch
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/leadscoring/batch') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::batchAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_batch',  '_route' => 'admin_zesharcrm_leadscoring_leadscoring_batch',);
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_edit
                        if (preg_match('#^/admin/zesharcrm/leadscoring/leadscoring/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_leadscoring_edit')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::editAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_edit',));
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_delete
                        if (preg_match('#^/admin/zesharcrm/leadscoring/leadscoring/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_leadscoring_delete')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::deleteAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_delete',));
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_show
                        if (preg_match('#^/admin/zesharcrm/leadscoring/leadscoring/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_zesharcrm_leadscoring_leadscoring_show')), array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::showAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_show',));
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_export
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/leadscoring/export') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::exportAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_export',  '_route' => 'admin_zesharcrm_leadscoring_leadscoring_export',);
                        }

                        // admin_zesharcrm_leadscoring_leadscoring_scoring
                        if ($pathinfo === '/admin/zesharcrm/leadscoring/leadscoring/scoring') {
                            return array (  '_controller' => 'ZesharCRM\\Bundle\\LeadScoringBundle\\Controller\\LeadScoringAdminController::scoringAction',  '_sonata_admin' => 'zeshar_crm_lead_scoring.admin.lead_scoring',  '_sonata_name' => 'admin_zesharcrm_leadscoring_leadscoring_scoring',  '_route' => 'admin_zesharcrm_leadscoring_leadscoring_scoring',);
                        }

                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/log')) {
                if (0 === strpos($pathinfo, '/admin/login')) {
                    // sonata_user_admin_security_login
                    if ($pathinfo === '/admin/login') {
                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::loginAction',  '_route' => 'sonata_user_admin_security_login',);
                    }

                    // sonata_user_admin_security_check
                    if ($pathinfo === '/admin/login_check') {
                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::checkAction',  '_route' => 'sonata_user_admin_security_check',);
                    }

                }

                // sonata_user_admin_security_logout
                if ($pathinfo === '/admin/logout') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::logoutAction',  '_route' => 'sonata_user_admin_security_logout',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::loginAction',  '_route' => 'fos_user_security_login',);
                }

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::logoutAction',  '_route' => 'fos_user_security_logout',);
            }

            if (0 === strpos($pathinfo, '/login')) {
                // sonata_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::loginAction',  '_route' => 'sonata_user_security_login',);
                }

                // sonata_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_sonata_user_security_check;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::checkAction',  '_route' => 'sonata_user_security_check',);
                }
                not_sonata_user_security_check:

            }

            // sonata_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::logoutAction',  '_route' => 'sonata_user_security_logout',);
            }

        }

        if (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ($pathinfo === '/resetting/request') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_request;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::requestAction',  '_route' => 'fos_user_resetting_request',);
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_fos_user_resetting_send_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_check_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
            }
            not_fos_user_resetting_check_email:

            if (0 === strpos($pathinfo, '/resetting/re')) {
                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::resetAction',));
                }
                not_fos_user_resetting_reset:

                // sonata_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_sonata_user_resetting_request;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::requestAction',  '_route' => 'sonata_user_resetting_request',);
                }
                not_sonata_user_resetting_request:

            }

            // sonata_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_sonata_user_resetting_send_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::sendEmailAction',  '_route' => 'sonata_user_resetting_send_email',);
            }
            not_sonata_user_resetting_send_email:

            // sonata_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_sonata_user_resetting_check_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::checkEmailAction',  '_route' => 'sonata_user_resetting_check_email',);
            }
            not_sonata_user_resetting_check_email:

            // sonata_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_sonata_user_resetting_reset;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_user_resetting_reset')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::resetAction',));
            }
            not_sonata_user_resetting_reset:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            if (0 === strpos($pathinfo, '/profile/edit-')) {
                // fos_user_profile_edit_authentication
                if ($pathinfo === '/profile/edit-authentication') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editAuthenticationAction',  '_route' => 'fos_user_profile_edit_authentication',);
                }

                // fos_user_profile_edit
                if ($pathinfo === '/profile/edit-profile') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editProfileAction',  '_route' => 'fos_user_profile_edit',);
                }

            }

            // sonata_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_sonata_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'sonata_user_profile_show');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::showAction',  '_route' => 'sonata_user_profile_show',);
            }
            not_sonata_user_profile_show:

            if (0 === strpos($pathinfo, '/profile/edit-')) {
                // sonata_user_profile_edit_authentication
                if ($pathinfo === '/profile/edit-authentication') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editAuthenticationAction',  '_route' => 'sonata_user_profile_edit_authentication',);
                }

                // sonata_user_profile_edit
                if ($pathinfo === '/profile/edit-profile') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editProfileAction',  '_route' => 'sonata_user_profile_edit',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if (rtrim($pathinfo, '/') === '/register') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::registerAction',  '_route' => 'fos_user_registration_register',);
            }

            if (0 === strpos($pathinfo, '/register/c')) {
                // fos_user_registration_check_email
                if ($pathinfo === '/register/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_registration_check_email;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                }
                not_fos_user_registration_check_email:

                if (0 === strpos($pathinfo, '/register/confirm')) {
                    // fos_user_registration_confirm
                    if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_confirm;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmAction',));
                    }
                    not_fos_user_registration_confirm:

                    // fos_user_registration_confirmed
                    if ($pathinfo === '/register/confirmed') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_confirmed;
                        }

                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                    }
                    not_fos_user_registration_confirmed:

                }

            }

            // sonata_user_registration_register
            if (rtrim($pathinfo, '/') === '/register') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'sonata_user_registration_register');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::registerAction',  '_route' => 'sonata_user_registration_register',);
            }

            if (0 === strpos($pathinfo, '/register/c')) {
                // sonata_user_registration_check_email
                if ($pathinfo === '/register/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_sonata_user_registration_check_email;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::checkEmailAction',  '_route' => 'sonata_user_registration_check_email',);
                }
                not_sonata_user_registration_check_email:

                if (0 === strpos($pathinfo, '/register/confirm')) {
                    // sonata_user_registration_confirm
                    if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_sonata_user_registration_confirm;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_user_registration_confirm')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmAction',));
                    }
                    not_sonata_user_registration_confirm:

                    // sonata_user_registration_confirmed
                    if ($pathinfo === '/register/confirmed') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_sonata_user_registration_confirmed;
                        }

                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmedAction',  '_route' => 'sonata_user_registration_confirmed',);
                    }
                    not_sonata_user_registration_confirmed:

                }

            }

        }

        if (0 === strpos($pathinfo, '/profile/change-password')) {
            // fos_user_change_password
            if ($pathinfo === '/profile/change-password') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_change_password;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ChangePasswordFOSUser1Controller::changePasswordAction',  '_route' => 'fos_user_change_password',);
            }
            not_fos_user_change_password:

            // sonata_user_change_password
            if ($pathinfo === '/profile/change-password') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_sonata_user_change_password;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ChangePasswordFOSUser1Controller::changePasswordAction',  '_route' => 'sonata_user_change_password',);
            }
            not_sonata_user_change_password:

        }

        // root
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'root');
            }

            return array (  '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::urlRedirectAction',  'path' => '/dashboard',  'permanent' => true,  '_route' => 'root',);
        }

        // dashboard
        if ($pathinfo === '/dashboard') {
            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\DashboardController::indexAction',  '_route' => 'dashboard',);
        }

        if (0 === strpos($pathinfo, '/widget')) {
            // widgetLoad
            if ($pathinfo === '/widget/load') {
                return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\DashboardController::loadWidgetAction',  '_route' => 'widgetLoad',);
            }

            // widgetSave
            if ($pathinfo === '/widget/save') {
                return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\DashboardController::saveWidgetAction',  '_route' => 'widgetSave',);
            }

        }

        if (0 === strpos($pathinfo, '/a')) {
            // shortyImportCSV
            if ($pathinfo === '/admin/csv/import') {
                return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CSVController::importFileAction',  '_route' => 'shortyImportCSV',);
            }

            if (0 === strpos($pathinfo, '/ajax/leads_')) {
                // ajaxLeadsDisplay
                if (0 === strpos($pathinfo, '/ajax/leads_display') && preg_match('#^/ajax/leads_display/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxLeadsDisplay')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadDisplayBlocksController::indexAction',));
                }

                // ajaxLeadsList
                if (0 === strpos($pathinfo, '/ajax/leads_list') && preg_match('#^/ajax/leads_list/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxLeadsList')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadListController::ajaxAction',));
                }

            }

        }

        // leadNoteAttach
        if ($pathinfo === '/uploads/attachments') {
            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\LeadDisplayBlocksController::leadNoteAttachActionAction',  '_route' => 'leadNoteAttach',);
        }

        if (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/admin')) {
                if (0 === strpos($pathinfo, '/admin/reports/user')) {
                    // reports_user_performance
                    if ($pathinfo === '/admin/reports/userPerformance') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ReportsController::userPerformanceAction',  '_route' => 'reports_user_performance',);
                    }

                    // reports_user_conversion
                    if ($pathinfo === '/admin/reports/userConversion') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ReportsController::userConversionAction',  '_route' => 'reports_user_conversion',);
                    }

                    // reports_user_audit
                    if ($pathinfo === '/admin/reports/userAudit') {
                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ReportsController::userAuditAction',  '_route' => 'reports_user_audit',);
                    }

                }

                // import_csv
                if ($pathinfo === '/admin/importCsv') {
                    return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\CSVController::indexAction',  '_route' => 'import_csv',);
                }

                if (0 === strpos($pathinfo, '/admin/product')) {
                    // changeProduct
                    if ($pathinfo === '/admin/product') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_changeProduct;
                        }

                        return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ProductController::indexAction',  '_route' => 'changeProduct',);
                    }
                    not_changeProduct:

                    // deleteProduct
                    if (preg_match('#^/admin/product/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_deleteProduct;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteProduct')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ProductController::deleteAction',));
                    }
                    not_deleteProduct:

                }

            }

            if (0 === strpos($pathinfo, '/ajax')) {
                // ajaxActivityList
                if (0 === strpos($pathinfo, '/ajax/activity_list') && preg_match('#^/ajax/activity_list/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxActivityList')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\ActivityListController::ajaxAction',));
                }

                // ajaxBillingInfo
                if (0 === strpos($pathinfo, '/ajax/billingInfo') && preg_match('#^/ajax/billingInfo/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxBillingInfo')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingInfoBlocksController::indexAction',));
                }

                // ajaxAccountInfo
                if (0 === strpos($pathinfo, '/ajax/accountInfo') && preg_match('#^/ajax/accountInfo/(?P<action>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ajaxAccountInfo')), array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountInfoBlocksController::indexAction',));
                }

            }

            // createAccount
            if ($pathinfo === '/account/create') {
                return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\AccountInfoBlocksController::showFormAction',  '_route' => 'createAccount',);
            }

        }

        // adnPaymentSilentPost
        if ($pathinfo === '/billing/updatePaymentHistory') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_adnPaymentSilentPost;
            }

            return array (  '_controller' => 'ZesharCRM\\Bundle\\CoreBundle\\Controller\\BillingInfoBlocksController::updatePaymentHistoryAction',  '_route' => 'adnPaymentSilentPost',);
        }
        not_adnPaymentSilentPost:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
