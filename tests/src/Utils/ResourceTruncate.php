<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Utils;

/**
 * <p>Class to truncate Resource</p>
 * @version 1.0
 */
class ResourceTruncate extends BaseTruncate
{
    /**
     * Truncate query table User
     * @return string
     */
    public function resourceTable() : string
    {
        $query = "truncate table `acl_resource`;";
        return $query;
    }
}