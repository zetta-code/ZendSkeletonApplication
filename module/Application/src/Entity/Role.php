<?php
/**
 * @link      http://github.com/zetta-code/zend-skeleton-application for the canonical source repository
 * @copyright Copyright (c) 2018 Zetta Code
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zetta\DoctrineUtil\Entity\AbstractDeletableEntity;
use Zetta\ZendAuthentication\Entity\RoleInterface;

/**
 * Role
 *
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role extends AbstractDeletableEntity implements RoleInterface
{
    const ID_SUPER = 1;
    const ID_ADMIN = 2;
    const ID_MANAGER = 3;
    const ID_MEMBER = 4;
    const ID_GUEST = 0;

    const SUPER   = 'Super';
    const ADMIN   = 'Admin';
    const MANAGER = 'Manager';
    const MEMBER  = 'Member';
    const GUEST   = 'Guest';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * Grupo constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get the Role id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the Role id
     * @param int $id
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the Role name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Role name
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the Role defaultName
     * @return string
     */
    public function getDefaultName()
    {
        return (string) self::ID_GUEST;
    }
}
