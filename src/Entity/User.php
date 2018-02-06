<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use \DateTime;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @author Tom Oram <tom@scl.co.uk>
 */
class User implements UserInterface, ProviderInterface
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
     * @ORM\Column(type="string", length=75, unique=true, nullable=true)
     */
    protected $username;
    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;
    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $displayName;
    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $state;
    /**
     * @var string
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $create;
    /**
     * @var string
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    protected $updated;
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Rioxygen\Zf2AuthCore\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    
    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles        = new ArrayCollection();
    }
    /**
     * Get id.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }
    /**
     * Get username.
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Set username.
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * Get email.
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set email.
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * Get displayName.
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
    /**
     * Set displayName.
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    /**
     * Get password.
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password.
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    /**
     * <p>eturn DateTime user Created</p>
     * @return DateTime
     */
    public function getCreate() : DateTime
    {
        return $this->create;
    }
    /**
     * <p>Return DateTime user updated</p>
     * @return DateTime
     */
    public function getUpdated() : DateTime
    {
        return $this->updated;
    }
    /**
     * <p>Set Created at</p>
     * @param DateTime $create
     */
    public function setCreate(DateTime $create)
    {
        $this->create = $create;
    }
    /**
     * <p>Update DateTime user modified</p>
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }
    /**
     * Get role.
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }
    /**
     * Add Role
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles->add($role);
    }
    /**
     * Remove Role
     * @param $role
     */
    public function removeRole($role)
    {
        $this->roles->removeElement($role);
    }    
    /**
     * Add roles to the user.
     * @param Collection $roles
     */
    public function addRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->add($role);
        }
    }
    /**
     * Remove roles from the user.
     * @param Collection $roles
     */
    public function removeRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->removeElement($role);
        }
    }
    /**
     * Regresa la informacion del Objeto
     * @return array
     */
    public function getArrayCopy()
    {
        $respuesta = get_object_vars($this);
        return $respuesta;
    }
}