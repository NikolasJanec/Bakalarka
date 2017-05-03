<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 01.03.2017
 * Time: 21:10
 */

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\Collection;

abstract class ApiEntity
{
    abstract function summary();
    /**
     * @param ApiEntity|ApiEntity[]|Collection $object
     * @return array
     */
    public static function prepare($object)
    {
        $result = [];
        if (is_array($object) || ($object instanceof Collection))
        {
            foreach ($object as $entity)
            {
                if ($entity instanceof ApiEntity)
                {
                    $result[] 			= $entity->summary();
                }
            }
        }
        elseif ($object instanceof ApiEntity)
        {
            $result 					= $object->summary();
        }
        return $result;
    }

}