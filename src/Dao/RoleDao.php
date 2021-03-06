<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Rioxygen\Zf2AuthCore\BaseInterface\DaoInterface;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;
use \Exception;

/**
 * RoleDao
 * @version 1.0
 */
class RoleDao implements DaoInterface
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
        $this->repository   = $this->em->getRepository('\Rioxygen\Zf2AuthCore\Entity\Role');
    }
    /**
     * Create or Update Role
     * @param BaseEntityInterface $role
     * @return bool
     */
    public function create(BaseEntityInterface $role) : bool
    {
        $control = array(true);
        try {
            $this->em->persist($role);
            $this->em->flush();
            $control[] = true;
        } catch (Exception $ex) {
            //var_dump($ex->getMessage());
            $this->logger->error($ex->getMessage());
            $control[] = false;
        }
        $respuesta = (bool)(!in_array(0, $control));
        return $respuesta;
    }
    /**
     * Delete Role Fisical Logical
     * @param Role $role
     * @return bool
     */
    public function delete(BaseEntityInterface $role) : bool
    {
        $control = array(1);
        try {
            $role->setState(0);
            $this->em->persist($role);
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
     * {@inheritsDoc}
     * @param array $params
     * @return Role
     */
    public function findOneBy(array $params) : Role
    {
        $role       = $this->repository->findOneBy($params);
        if (!($role instanceof  Role)) {
            $role =  new Role();
        }
        return $role;
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
        $respuesta = $this->repository->getAllRoles($page = 1, $items = 100, $state = 1);
        return $respuesta;
    }
}