<?php
/**
 * Rioxygen
 * @
 * @package Zf2AuthCore
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Rioxygen\Zf2AuthCore\Entity\ControllerGuard;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Rioxygen\Zf2AuthCore\BaseInterface\DaoInterface;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;
use \Exception;

/**
 * ControllerGuardDao
 * @version 1.0
 */
class ControllerGuardDao implements DaoInterface
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
        $this->repository   = $this->em->getRepository('\Rioxygen\Zf2AuthCore\Entity\ControllerGuard');
    }
    /**
     * Determinate if we can create or update ControllerGuard
     * @param BaseEntityInterface $controller
     * @return int
     */
    public function create(BaseEntityInterface $controller) : bool
    {
        $control = array(true);
        try {
            $this->em->persist($controller);
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
     * DeleteControllerGuard Logical
     * @param BaseEntityInterface $controller
     * @return bool
     */
    public function delete(BaseEntityInterface $controller) : bool
    {
        $control = array(1);
        try {
            $this->em->remove($controller);
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
     * @return Rule
     */
    public function findOneBy(array $params) : Resource
    {
        $controller       = $this->repository->findOneBy($params);
        if (!($controller instanceof ControllerGuard)) {
            $controller =  new ControllerGuard();
        }
        return $controller;
    }
    /**
     * Get All
     * @param int $page
     * @param int $items
     * @param int $state
     * @return Paginator
     */
    public function getAll($page = 0, $items = 100, $state = 1) : Paginator
    {
        $respuesta = $this->repository->getAllControllerGuardRepository($page = 0, $items = 100, $state = 1);
        return $respuesta;
    }
}