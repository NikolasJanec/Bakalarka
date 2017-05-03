<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 01.03.2017
 * Time: 21:16
 */

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class DeviceReader
{

    private $id;

    private $typeReaderId;

    private $sectionId;

    private $name;

    private $note;

    private $uuid;

    private  $token;

    private  $ipAddress;

    private $portNumber;

    private $lastSyncAt;

    private $section;

    private $typeReader;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $updatedAt;

    private $logs;

    /**
     * DeviceReader constructor.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
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
    public function getTypeReaderId()
    {
        return $this->typeReaderId;
    }

    /**
     * @param mixed $typeReaderId
     */
    public function setTypeReaderId($typeReaderId)
    {
        $this->typeReaderId = $typeReaderId;
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
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getPortNumber()
    {
        return $this->portNumber;
    }

    /**
     * @param mixed $portNumber
     */
    public function setPortNumber($portNumber)
    {
        $this->portNumber = $portNumber;
    }

    /**
     * @return mixed
     */
    public function getLastSyncAt()
    {
        return $this->lastSyncAt;
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
        return $this->updatedAt;
    }

    /**
     * @param mixed $lastSyncAt
     */
    public function setLastSyncAt($lastSyncAt)
    {
        $this->lastSyncAt = $lastSyncAt;
    }

    /**
     * @return mixed
     */
    public function getTypeReader()
    {
        return $this->typeReader;
    }

    /**
     * @param mixed $typeReader
     */
    public function setTypeReader($typeReader)
    {
        $this->typeReader = $typeReader;
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



}