<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Psr\Log\LoggerInterface;
use Rioxygen\Zf2AuthCore\Entity\Rule;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Rioxygen\Zf2AuthCore\BaseInterface\DaoInterface;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;
use \Exception;

/**
 * RuleDao
 * @version 1.0
 */
class RuleDao implements DaoInterface
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
        $this->repository   = $this->em->getRepository('\Rioxygen\Zf2AuthCore\Entity\Rule');
    }
    /**
     * Determinate if we can create or update Rule
     * @param BaseEntityInterface $rule
     * @return bool
     */
    public function create(BaseEntityInterface $rule) : bool
    {
        $control = array(true);
        try {
            $this->em->persist($rule);
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
     * Delete Rule  Logical
     * @param BaseEntityInterface $rule
     * @return type
     */
    public function delete(BaseEntityInterface $rule)
    {
        $control = array(1);
        try {
            $this->em->persist($rule);
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
    public function findOneBy(array $params) : Rule
    {
        $rule       = $this->repository->findOneBy($params);
        if (!($rule instanceof Rule)) {
            $rule =  new Rule();
        }
        return $rule;
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
        $respuesta = $this->repository->getAll($page = 1, $items = 100, $state = 1);
        return $respuesta;
    }
}