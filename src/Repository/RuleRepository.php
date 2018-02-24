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
class RuleRepository extends EntityRepository
{
    /**
     * Get all Rule with filter active/inactive
     * @param integer $page
     * @param integer $items
     * @param boolean $state
     * @return Paginator
     */
    public function getAll($page = 1, $items = 100, $state = 1) : Paginator
    {
        $offset = $page * $items;
        $qb = $this->_em->createQueryBuilder();
        $qb->select("u")
            ->from("Rioxygen\Zf2AuthCore\Entity\Rule", "u")
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($items);
        $paginator          = new Paginator($qb);
        return $paginator;
    }
}