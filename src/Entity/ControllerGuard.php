<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;

/**
 * Represent Controller Guard
 * @ORM\Entity(repositoryClass="Rioxygen\Zf2AuthCore\Repository\ControllerGuardRepository")
 * @ORM\Table(name="acl_controllerguard")
 * @version 1.0
 */
class ControllerGuard implements BaseEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $controller;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $action;
    
    /**
     * @ManyToMany(targetEntity="Rioxygen\Zf2AuthCore\Entity\Role")
     * @ORM\JoinTable(name="controllerguard_role_relation",
     *      joinColumns={@ORM\JoinColumn(name="controllerguardId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="roleId", referencedColumnName="id")}
     * )
     */
    private $roles;
    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
    /**
     * Return Id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * SetAttribute
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
        /**
     * Return controller
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }
    /**
     * Set
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    /**
     * GetAttributteName
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Set AtributeName
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    /**
     * GetAttributteName
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }
    /**
     * Add AttributeName
     * @param type $role
     * @return $this
     */
    public function addRoles(Role $role)
    {
        $this->roles->add($role);
    }
    /**
     * Remove Role
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
    }
}