<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use \PHPUnit_Framework_TestCase;
use Rioxygen\Zf2AuthCore\Utils\Database;
use Rioxygen\Zf2AuthCore\Entity\User;
use Rioxygen\Zf2AuthCore\Bootstrap;

class UserDaoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var \PDO
     */
    private $pdo;
    
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config = Bootstrap::getConfig();
        $objDB = new \Rioxygen\Zf2AuthCore\Utils\Database($config['db']['host'], 
                $config['db']['dbname'], 
                $config['db']['user'], 
                $config['db']['password']);
        $this->pdo = $objDB->getConnection();
        $this->em = $objDB->getEntityManager(array('src/Entity'),$config['db']);
    }
    public function testGetUsers()
    {
        $this->assertTrue(true);
    }
}