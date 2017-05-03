<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 17:25
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\EntityRepository;

class ProfileRepository extends EntityRepository
{
    public function findAllProfilesBySection($id, $filter)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("profile");
        $query->from("CoreBundle:Profile", "profile");

        if (!empty($id)) {
            $query->where("profile.sectionId = :sectionID");
            $query->setParameter(":sectionID", $id);
            if (!empty($filter['query'])) {
                $query->andWhere("profile.name LIKE :query");
                $query->setParameter("query", "%" . $filter['query'] . "%");
            }
        }

        return $query->getQuery()->getResult();
    }

    public function findOneProfile($id_section, $id_user)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("profile");
        $query->from("CoreBundle:Profile", "profile");

        $query->where(" :idUser MEMBER OF profile.users");
        $query->setParameter(":idUser", $id_user);
        $query->andWhere("profile.sectionId = :sectionID");
        $query->setParameter(":sectionID", $id_section);

        return $query->getQuery()->getResult();
    }

}