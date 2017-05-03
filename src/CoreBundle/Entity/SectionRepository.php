<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 20.04.2017
 * Time: 21:24
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\EntityRepository;

class SectionRepository extends EntityRepository
{

    public function findAllByFilteraa($filter) {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("section");
        $query->from("CoreBundle:Section", "section");

        if (!empty($filter['sec_name']))
        {
            $query->where(" :idUser MEMBER OF section.users");
            $query->setParameter(":idUser", $filter['user_id']);
            $query->andWhere("section.name LIKE :query");
            $query->setParameter("query", "%" . $filter['sec_name'] . "%");
        }

        return $query->getQuery()->getResult();
    }

    public function findSection($userID, $sectionID) {

        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("section");
        $query->from("CoreBundle:Section", "section");

        $query->where(" :idUser MEMBER OF section.users");
        $query->setParameter(":idUser", $userID);
        $query->andWhere("section.id = :sectionID");
        $query->setParameter(":sectionID", $sectionID);

        return $query->getQuery()->getResult();
    }

    public function findAllSectionsForUser($id_user, $id_me){
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("section");
        $query->from("CoreBundle:Section", "section");

        $query->where(" :idMe MEMBER OF section.users");
        $query->setParameter(":idMe", $id_me);
        $query->where(" :idUser NOT MEMBER OF section.users");
        $query->setParameter(":idUser", $id_user);

        return $query->getQuery()->getResult();

    }

}