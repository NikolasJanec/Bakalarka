<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 01.03.2017
 * Time: 21:15
 */

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Role
{
    private $id;

    private $code;

    private $description;

    private $createdAt;

    private $updatedAt;

    private $users;

    /**
     * Record constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function fillCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }
    public function fillUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * FIXME: bidirectional relationship
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
    }
    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

}