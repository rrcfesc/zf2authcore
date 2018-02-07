<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Utils;

/**
 * <p>Class to truncate Roles</p>
 * @version 1.0
 */
class RoleTruncate extends BaseTruncate
{
    /**
     * Truncate query  table  Role
     * @return string
     */
    public function roleTable() : string
    {
        $query = "truncate table `role`;";
        return $query;
    }
}