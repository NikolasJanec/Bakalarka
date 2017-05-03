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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class User extends ApiEntity implements UserInterface, \Serializable
{
    private $id;

    private $roleId;

    private $firstName;

    private $lastName;

    private $email;

    private $uuid;

    private $password;

    private $userName;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $updatedAt;

    /** @var Role */
    private $role;

    private $devices;

    private $logs;

    private $entrys;

    private $logsAdministrator;

    private $sections;

    private $profiles;

    /**
     * Record constructor.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->entrys = new ArrayCollection();
        $this->devices = new ArrayCollection();
        $this->logsAdministrator = new ArrayCollection();
        $this->sections = new ArrayCollection();
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
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
     * @param Device $device
     */
    public function addDevice(Device $device)
    {
        $this->devices->add($device);
    }
    /**
     * @param Device $device
     */
    public function removeDevice(Device $device)
    {
        $this->devices->removeElement($device);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt2()
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
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * FIXME: bidirectional relationship
     * @param Log $log
     */
    public function addAdministrotorLof(Log $log)
    {
        $this->logs->add($log);
    }

    /**
     * @param Log $log
     */
    public function removeAdministratorLog(Log $log)
    {
        $this->logs->removeElement($log);
    }

    /**
     * @return ArrayCollection
     */
    public function getLogsAdministrator()
    {
        return $this->logsAdministrator;
    }

    /**
     * FIXME: bidirectional relationship
     * @param Section $section
     */
    public function addSection(Section $section)
    {
        $this->sections->add($section);
    }
    /**
     * @param Section $section
     */
    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getSections()
    {
        return $this->sections;
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

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role|string[] The user roles
     */
    public function getRoles()
    {
        return [$this->getRole()->getCode()];
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
    }

    public function summary()
    {

        return [
            'first_name'        => (string) $this->getFirstName(),
            'last_name'         => (string) $this->getLastName(),
            'rola'              => (string) $this->role->getCode()
        ];
    }

}