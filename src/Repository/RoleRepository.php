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
 * RoleRepository Extends
 * @version 1.0
 */
class RoleRepository extends EntityRepository
{
    /**
     * Get all Role with filter active/inactive
     * @param integer $page
     * @param integer $items
     * @param boolean $state
     * @return Paginator
     */
    public function getAllRoles($page = 1, $items = 100, $state = 1) : Paginator
    {
        $offset = $page * $items;
        $qb = $this->_em->createQueryBuilder();
        $qb->select("r")
            ->from("Rioxygen\Zf2AuthCore\Entity\Role", "r")
            ->where($qb->expr()->in("r.state", $state))
            ->orderBy('r.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($items);
        $paginator          = new Paginator($qb);
        return $paginator;
    }
}