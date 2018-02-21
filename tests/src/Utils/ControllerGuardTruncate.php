<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Utils;

/**
 * <p>Class to truncate acl_controllerguard</p>
 * @version 1.0
 */
class ControllerGuardTruncate extends BaseTruncate
{
    /**
     * Truncate query  table acl_controllerguard
     * @return string
     */
    public function ControllerGuardTable() : string
    {
        $query = "truncate table `acl_controllerguard`;";
        return $query;
    }
}