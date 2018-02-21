<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\BaseInterface;

use Doctrine\ORM\EntityManager;
use Rioxygen\Zf2AuthCore\BaseInterface\BaseEntityInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * <p>Basic interfaces to implements on DAO</p>
 * @version 0.9
 */
interface DaoInterface
{
    public function __construct(EntityManager $em, LoggerInterface $logger);
    public function create(BaseEntityInterface $entity);
    public function delete(BaseEntityInterface $entity);
    public function getAll($page = 0, $items = 100, $state = 1) : Paginator;
}