<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Entity;

use Zend\Permissions\Acl\Resource\ResourceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ACL Resource
 * @ORM\Entity
 * @ORM\Table(name="acl_resource")
 */
class Resource implements ResourceInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $description;
    /**
     * {@inheritDoc}
     * @see \Zend\Permissions\Acl\Resource\ResourceInterface::getResourceId()
     */
    public function getResourceId()
    {
        return $this->id;
    }
    /**
     * Return attribute
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Return attribute
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set Attribute
     * @param string $name Attribute
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Return attribute
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set Attribute
     * @param string $description Attribute
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}