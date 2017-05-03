<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 15:37
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\EntityRepository;

class DeviceReaderRepository extends EntityRepository
{
    public function findAllReadersBySection($id, $filter)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("deviceReader");
        $query->from("CoreBundle:DeviceReader", "deviceReader");
        $query->where("1 = 1 ");

        if (!empty($id)) {
            $query->andWhere("deviceReader.sectionId = :sectionID");
            $query->setParameter(":sectionID", $id);
            if (!empty($filter['query'])) {
                $query->andWhere("deviceReader.name LIKE :query");
                $query->setParameter("query", "%" . $filter['query'] . "%");
            }
        }

        return $query->getQuery()->getResult();
    }
}