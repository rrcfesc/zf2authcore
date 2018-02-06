<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Rioxygen\Zf2AuthCore\Entity\User;

/**
 * UserDao or 
 */
class UserDao
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var RepositoryFactory
     */
    private $repository;
    /**
     * Class construct
     * @param Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('Claroshop\Core\Entity\Cms\User');
    }
    /**
     * Determinate if we can create or update User
     * @param User $user
     * @return boolean
     */
    public function createUser(User $user) : boolean
    {
        $control = array(1);
        return (!in_array(0, $control));
    }
}