<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 10.04.2017
 * Time: 20:36
 */

namespace CoreBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Profile
{
    private $id;

    private $sectionId;

    private $name;

    private $entrys;

    private $users;

    private $section;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Record constructor.
     */
    public function __construct()
    {
        $this->entrys = new ArrayCollection();
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
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * @param mixed $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * FIXME: bidirectional relationship
     * @param Entry $entry
     */
    public function addEntry(Entry $entry)
    {
        $this->entrys->add($entry);
    }
    /**
     * @param Entry $entry
     */
    public function removeEntry(Entry $entry)
    {
        $this->entrys->removeElement($entry);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getEntrys()
    {
        return $this->entrys;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function fillCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }
    public function fillUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }


}