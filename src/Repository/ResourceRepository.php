<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Entity Extends
 * @version 1.0
 */
class ResourceRepository extends EntityRepository
{
    /**
     * Get all ControllerGuard
     * @param integer $page
     * @param integer $items
     * @param boolean $state
     * @return Paginator
     */
    public function getAll($page = 0, $items = 300, $state = 1) : Paginator
    {
        $offset = $page * $items;
        $qb = $this->_em->createQueryBuilder();
        $qb->select("cr")
            ->from("Rioxygen\Zf2AuthCore\Entity\Resource", "cr")
            ->orderBy('cr.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($items);
        $paginator          = new Paginator($qb);
        return $paginator;
    }
}