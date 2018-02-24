<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Utils;

/**
 * <p>Class to truncate Rule</p>
 * @version 1.0
 */
class RuleTruncate extends BaseTruncate
{
    /**
     * Truncate query table Rule
     * @return string
     */
    public function ruleTable() : string
    {
        $query = "truncate table `acl_rule`;";
        return $query;
    }
}