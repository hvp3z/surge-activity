<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityStatus;

use Sonata\AdminBundle\Controller\CRUDController as CRUDController;

use Symfony\Component\HttpFoundation\Request;

class ActivityCRUDController extends CRUDController
{
    public function closeActivityAction()
    {
        $activity = $this->lookupLead();
//        if ($activity->getStatus() === ActivityStatus::OPEN) {
//            $activityRepository = $this->getDoctrine()->getRepository('ZesharCRM\Bundle\CoreBundle\Entity\Activity');
//            $activityRepository->closeActivity($activity);
//            $this->addFlash('sonata_flash_success', sprintf('Activity "%s" was closed.', $activity->getTitle()));
//        } else {
//            $this->addFlash('sonata_flash_error', 'Cannot close activity - it was already closed before.');
//        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($activity);
        $em->flush();
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    private function lookupLead() {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $lead = $this->admin->getObject($id);

        if (!$lead) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        return $lead;
    }

}
