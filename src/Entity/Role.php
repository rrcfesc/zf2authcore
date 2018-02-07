<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * An example entity that represents a role.
 * @ORM\Entity
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="Rioxygen\Zf2AuthCore\Repository\RoleRepository")
 * @author Tom Oram <tom@scl.co.uk>
 */
class Role implements RoleInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $roleId;
    /**
     * @var Role
     * @ORM\Column(name="parent", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Rioxygen\Zf2AuthCore\Entity\Role")
     */
    protected $parent;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $state;
    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set the id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }
    /**
     * Get the role id.
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
    /**
     * Set the role id.
     *
     * @param string $roleId
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
    }
    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Set the parent role.
     *
     * @param Role $parent
     *
     * @return void
     */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Get state.
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * Set state.
     * @param int $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}
