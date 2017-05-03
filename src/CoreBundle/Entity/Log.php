<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 01.03.2017
 * Time: 21:16
 */

namespace CoreBundle\Entity;


class Log
{

    private $id;

    private $deviceReaderId;

    private $administratorId;

    private $userId;

    private $deviceId;

    private $sectionId;

    private $entryId;

    private $status;

    private $activity;

    private $message;

    private $additionalInfo;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $updatedAt;

    private $administrator;

    private $user;

    private $device;

    private $deviceReader;

    private $section;

    private $entry;

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
    public function getDeviceReaderId()
    {
        return $this->deviceReaderId;
    }

    /**
     * @param mixed $deviceReaderId
     */
    public function setDeviceReaderId($deviceReaderId)
    {
        $this->deviceReaderId = $deviceReaderId;
    }

    /**
     * @return mixed
     */
    public function getAdministratorId()
    {
        return $this->administratorId;
    }

    /**
     * @param mixed $administratorId
     */
    public function setAdministratorId($administratorId)
    {
        $this->administratorId = $administratorId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @param mixed $deviceId
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
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
    public function getEntryId()
    {
        return $this->entryId;
    }

    /**
     * @param mixed $entryId
     */
    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @param mixed $additionalInfo
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * @return mixed
     */
    public function getAdministrator()
    {
        return $this->administrator;
    }

    /**
     * @param mixed $administrator
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function getDeviceReader()
    {
        return $this->deviceReader;
    }

    /**
     * @param mixed $deviceReader
     */
    public function setDeviceReader($deviceReader)
    {
        $this->deviceReader = $deviceReader;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param mixed $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
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
    public function getCreatedAt2()
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

}