<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Utils;

/**
 * <p>Class to truncate users</p>
 * @version 1.0
 */
class UserTruncate extends BaseTruncate
{
    /**
     * Truncate query table User
     * @return string
     */
    public function userTable() : string
    {
        $query = "truncate table `users`;";
        return $query;
    }
}