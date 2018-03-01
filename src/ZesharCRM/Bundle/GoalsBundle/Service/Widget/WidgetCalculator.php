<?php

namespace ZesharCRM\Bundle\GoalsBundle\Service\Widget;

use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;
use ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment;

abstract class WidgetCalculator extends CommonWidget
{

    public static function getGoalMonth($entities, $user)
    {
        $result = array();
        $isAdmin = self::isAdmin($user);
        foreach ($entities as $key=>$entity) {
            if ($entity instanceof GoalAssignment) {
                $category = $entity->getGoal()->getGoalCategory();

				if($category){
					$category = $category->getLineCode();
					$categoryTitle = $entity->getGoal()->getGoalCategory()->getTitle();
					$estimated = $entity->getEstimated();

                    $result[$categoryTitle] = array(
                        'id' => $entity->getId(),
                        'current' => isset($result[$categoryTitle]) ? $result[$categoryTitle]['current'] + $entity->getCurrent() : $entity->getCurrent(),
                        'estimated' => $estimated,
                        'title' => $categoryTitle
                    );

				}
            }
        }
        return $result;
    }

}
