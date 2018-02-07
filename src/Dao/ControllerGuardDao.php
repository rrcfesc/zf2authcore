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
#use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use \Exception;

/**
 * ControllerGuardDao
 * @version 1.0
 */
class ControllerGuardDao
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
     * @param ControllerGuard $controller
     * @return int
     */
    public function createControllerGuard(ControllerGuard $controller) : bool
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
     * @param ControllerGuard $controller
     * @return bool
     */
    public function deleteControllerGuard(ControllerGuard $controller) : bool
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
     * Get All
     * @param int $page
     * @param int $items
     * @return Paginator
     */
    public function getAll($page = 0, $items = 100) : Paginator
    {
        $respuesta = $this->repository->getAllControllerGuardRepository($page = 1, $items = 100);
        return $respuesta;
    }
}