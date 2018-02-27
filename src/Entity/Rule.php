<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rioxygen\Zf2AuthCore\Entity\Resource;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;

/**
 * ACL Resource Rule
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rioxygen\Zf2AuthCore\Repository\RuleRepository")
 * @ORM\Table(name="acl_rule")
 */
class Rule implements BaseEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Rioxygen\Zf2AuthCore\Entity\Resource")
     * @ORM\JoinColumn(name="resourceId", referencedColumnName="id")
     */
    private $resource;
    /**
     * @ORM\ManyToOne(targetEntity="Rioxygen\Zf2AuthCore\Entity\Role")
     * @ORM\JoinColumn(name="roleId", referencedColumnName="id")
     */
    private $role;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $privilege;
    /**
     * Get attribute
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get attribute
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }
    /**
     * Set Attribute
     * @param Resource $resource Attribute
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }
    /**
     * Get attribute
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * Set Attribute
     * @param Role $role Attribute
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
    }
    /**
     * Get attribute
     * @return string
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }
    /**
     * Set Attribute
     * @param string $privilege Attribute
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
    }
}