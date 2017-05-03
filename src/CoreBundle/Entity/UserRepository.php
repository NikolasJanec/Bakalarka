<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 14.03.2017
 * Time: 15:12
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function countUsers()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("COUNT(u)");
        $query->from("CoreBundle:User", 'u');
        return $query->getQuery()->getSingleScalarResult();
    }

    public function findAllByFilter($filter, $sectionId, $userRoleId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("user");
        $query->from("CoreBundle:User", "user");
        $query->where("1 = 1");
//
//        if (!empty($filter['firstName'])) {
//            $query->andWhere("user.firstName LIKE :firstName");
//            $query->setParameter("firstName", "%" . $filter['firstName'] . "%");
//        }
//
//        if (!empty($filter['lastName'])) {
//            $query->andWhere("user.lastName LIKE :lastName");
//            $query->setParameter("lastName", "%" . $filter['lastName'] . "%");
//        }
            $query->andWhere(" :idRole = user.roleId");
            $query->setParameter(":idRole", $userRoleId);
            $query->andWhere(" :idSection IN user.sections");
            $query->setParameter(":idSection", $sectionId);



        if (!empty($filter['query'])) {
            $query->andWhere("CONCAT(user.firstName, ' ', user.lastName) LIKE :query");
            $query->setParameter("query", "%" . $filter['query'] . "%");
        }

        return $query->getQuery()->getResult();
    }

    public function findAllAdministratorsBySection($id, $administratorRole)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("user");
        $query->from("CoreBundle:User", "user");

        if (!empty($id)) {
            $query->where("user.roleId = :roleID");
            $query->setParameter(":roleID", $administratorRole);
            $query->andWhere(" :idSection MEMBER OF user.sections");
            $query->setParameter(":idSection", $id);
        }

        return $query->getQuery()->getResult();
    }

    public function findSpecificAdministratorsBySection($id, $administratorRole, $filter)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("user");
        $query->from("CoreBundle:User", "user");

        if (!empty($id)) {
            $query->where("user.roleId = :roleID");
            $query->setParameter(":roleID", $administratorRole);
            $query->andWhere(" :idSection MEMBER OF user.sections");
            $query->setParameter(":idSection", $id);
            $query->andWhere("CONCAT(user.firstName, ' ', user.lastName) LIKE :query");
            $query->setParameter("query", "%" . $filter['query'] . "%");
        }

        return $query->getQuery()->getResult();
    }

    public function findSpecificAdministratorsNoInSection($id, $administratorRole, $filter)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("user");
        $query->from("CoreBundle:User", "user");

        if (!empty($id)) {
            $query->where("user.roleId = :roleID");
            $query->setParameter(":roleID", $administratorRole);
            $query->andWhere(" :idSection NOT MEMBER OF user.sections");
            $query->setParameter(":idSection", $id);
            if (!empty($filter['query'])) {
                $query->andWhere("CONCAT(user.firstName, ' ', user.lastName) LIKE :query");
                $query->setParameter("query", "%" . $filter['query'] . "%");
            }
        }

        return $query->getQuery()->getResult();
    }



}