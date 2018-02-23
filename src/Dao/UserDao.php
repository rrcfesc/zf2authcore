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
use Psr\Log\LoggerInterface;
use Rioxygen\Zf2AuthCore\BaseInterface\DaoInterface;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use \Exception;

/**
 * UserDao
 * @version 1.0
 */
class UserDao implements DaoInterface
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
     * @var LoggerInterface 
     */
    private $logger;
    /**
     * Class construct
     * @param Doctrine\ORM\EntityManager $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em           = $em;
        $this->logger       = $logger;
        $this->repository   = $this->em->getRepository('\Rioxygen\Zf2AuthCore\Entity\User');
    }
    /**
     * Determinate if we can create or update User
     * @param User $user
     * @return int
     */
    public function create(BaseEntityInterface $user) : bool
    {
        $control = array(true);
        try {
            $this->em->persist($user);
            $this->em->flush();
            $control[] = true;
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            $control[] = false;
        }
        $respuesta = (bool)(!in_array(0, $control));
        return $respuesta;
    }
    /**
     * delete Logical
     * @param User $user
     * @return bool
     */
    public function delete(BaseEntityInterface $user) : bool
    {
        $control = array(1);
        try {
            $user->setState(0);
            $this->em->persist($user);
            $this->em->flush();
            $control[] = true;
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            $control[] = false;
        }
        $respuesta = (bool)(!in_array(0, $control));
        return $respuesta;
    }
    /**
     * Get By User Id
     * @param string $id
     */
    public function getById(string $id) : User
    {
        $user       = $this->repository->findOneBy(array('id'=>$id));
        if (!($user instanceof  User)) {
            $user =  new User();
        }
        return $user;
    }
    /**
     * {@inheritsDoc}
     * @param array $params
     * @return User
     */
    public function findOneBy(array $params) : User
    {
        $user       = $this->repository->findOneBy($params);
        if (!($user instanceof  User)) {
            $user =  new User();
        }
        return $user;
    }
    /**
     * Get All User 
     * @param int $page
     * @param int $items
     * @param boolean $state
     * @return Paginator
     */
    public function getAll($page = 0, $items = 100, $state = 1) : Paginator
    {
        $respuesta = $this->repository->getAllUsers($page = 1, $items = 100, $state = 1);
        return $respuesta;
    }
}