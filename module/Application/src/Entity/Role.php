<?php
/**
 * @link      http://github.com/zetta-code/zend-skeleton-application for the canonical source repository
 * @copyright Copyright (c) 2018 Zetta Code
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zetta\DoctrineUtil\Entity\AbstractEntity;
use Zetta\ZendAuthentication\Entity\RoleInterface;

/**
 * Role
 *
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role extends AbstractEntity implements RoleInterface
{
    const ID_ADMIN = 1;
    const ID_MEMBER = 2;

    const ADMIN = 'Admin';
    const MEMBER = 'Member';
    const GUEST = 'Guest';

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
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * Grupo constructor.
     */
    public function __construct()
    {
        $this->active = true;
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
     * Get the Role active
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the Role active
     * @param bool $active
     * @return Role
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get the Role defaultName
     * @return string
     */
    public function getDefaultName()
    {
        return 'Guest';
    }
}
