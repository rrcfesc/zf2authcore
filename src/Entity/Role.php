<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Permissions\Acl\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;

/**
 * An example entity that represents a role.
 * @ORM\Entity
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="Rioxygen\Zf2AuthCore\Repository\RoleRepository")
 * @author Tom Oram <tom@scl.co.uk>
 */
class Role implements RoleInterface, BaseEntityInterface
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
     * @ORM\Column(name="parent")
     * @ORM\ManyToOne(targetEntity="Rioxygen\Zf2AuthCore\Entity\Role")
     */
    protected $parent;
    /**
     * @ORM\ManyToMany(targetEntity="Rioxygen\Zf2AuthCore\Entity\ControllerGuard")
     * @ORM\JoinTable(name="controllerguard_role_relation",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="controllerguard_id", referencedColumnName="id")}
     * )
     */
    protected $controllers;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $state;
    /**
     * Role constructor.
     */
    public function __construct()
    {
        $this->controllers = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getControllers()
    {
        return $this->controllers;
    }
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
     * @param string $roleId
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
     * @param string $parent
     */
    public function setParent($parent)
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
