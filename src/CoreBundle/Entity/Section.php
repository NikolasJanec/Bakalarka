<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 10.04.2017
 * Time: 20:31
 */

namespace CoreBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Section
{

    private $id;

    private $name;

    private $entrys;

    private $logs;

    private $deviceReaders;

    private $profiles;

    private $users;

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
        $this->users = new ArrayCollection();
        $this->deviceReaders = new ArrayCollection();
        $this->entrys = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->profiles = new ArrayCollection();
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
     * @param Log $log
     */
    public function addLog(Log $log)
    {
        $this->logs->add($log);
    }
    /**
     * @param Log $log
     */
    public function removeLog(Log $log)
    {
        $this->logs->removeElement($log);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * FIXME: bidirectional relationship
     * @param DeviceReader $deviceReader
     */
    public function addDeviceReader(DeviceReader $deviceReader)
    {
        $this->deviceReaders->add($deviceReader);
    }
    /**
     * @param DeviceReader $deviceReader
     */
    public function removeDeviceReader(DeviceReader $deviceReader)
    {
        $this->deviceReaders->removeElement($deviceReader);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getDeviceReaders()
    {
        return $this->deviceReaders;
    }

    /**
     * FIXME: bidirectional relationship
     * @param Profile $profile
     */
    public function addProfile(Profile $profile)
    {
        $this->profiles->add($profile);
    }
    /**
     * @param Profile $profile
     */
    public function removeProfile(Profile $profile)
    {
        $this->profiles->removeElement($profile);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }




}