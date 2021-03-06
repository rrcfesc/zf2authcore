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
class UserRepository extends EntityRepository
{
    /**
     * Get all User with filter active/inactive
     * @param integer $page
     * @param integer $items
     * @param boolean $state
     * @return Paginator
     */
    public function getAllUsers($page = 1, $items = 100, $state = 1) : Paginator
    {
        $offset = $page * $items;
        $qb = $this->_em->createQueryBuilder();
        $qb->select("u")
            ->from("Rioxygen\Zf2AuthCore\Entity\User", "u")
            ->where($qb->expr()->in("u.state", $state))
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($items);
        $paginator          = new Paginator($qb);
        return $paginator;
    }
}