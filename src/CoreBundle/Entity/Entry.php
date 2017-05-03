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


class Entry
{
    private $id;

    private $deviceReaderId;

    private $userId;

    private $sectionId;

    private $profileId;

    private $dayOfMonth;

    private $dayOfWeek;

    private $year;

    private $month;

    /**
     * @var \DateTime
     */
    private $from;

    /**
     * @var \DateTime
     */
    private $until;

    private $isActive;

    private $createdAt;

    private $updatedAt;

    private $user;

    private $section;

    private $profile;

    private $logs;

    /**
     * Record constructor.
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
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param mixed $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getIsActive2()
    {
        if ($this->isActive == 0){
            return "Zakázané";
        }else{
            return "Povolené";
        }
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
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
    public function getDayOfMonth()
    {
        return $this->dayOfMonth;
    }

    /**
     * @param mixed $dayOfMonth
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->dayOfMonth = $dayOfMonth;
    }

    /**
     * @return mixed
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @return mixed
     */
    public function getDayOfWeek2()
    {
        switch ($this->dayOfWeek) {
            case 1:
                return "Pondelok";
                break;
            case 2:
                return "Utorok";
                break;
            case 3:
                return "Streda";
                break;
            case 4:
                return "Štvrtok";
                break;
            case 5:
                return "Piatok";
                break;
            case 6:
                return "Sobota";
                break;
            case 7:
                return "Nedeľa";
                break;
        }

    }

    /**
     * @param mixed $dayOfWeek
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getFrom2()
    {
        return $this->from->format('H:i:s');
    }

    /**
     * @return mixed
     */
    public function getFromMinutes()
    {
        return $this->from->format('i');
    }
    /**
     * @return mixed
     */
    public function getFromHours()
    {
        return $this->from->format('H');
    }

    /**
     * @return mixed
     */
    public function getUntilMinutes()
    {
        return $this->until->format('i');
    }

    /**
     * @return mixed
     */
    public function getUntilHours()
    {
        return $this->until->format('H');
    }



    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @return mixed
     */
    public function getUntil2()
    {
        return $this->until->format('H:i:s');
    }

    /**
     * @param mixed $until
     */
    public function setUntil($until)
    {
        $this->until = $until;
    }


    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
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