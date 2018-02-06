<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use \PHPUnit_Framework_TestCase;
use Rioxygen\Zf2AuthCore\Utils\Database;
use Rioxygen\Zf2AuthCore\Utils\Mocker;
use Rioxygen\Zf2AuthCore\Dao\UserDao;
use Rioxygen\Zf2AuthCore\Entity\User;
use Zend\Log\Logger;
use \Bootstrap;

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
     * @var Logger 
     */
    private $logger;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config     = Bootstrap::getConfig();
        $mocker     = new Mocker();
        $objDB      = new Database($config['db']['host'], 
                $config['db']['dbname'], 
                $config['db']['user'], 
                $config['db']['password']);
        $this->pdo  = $objDB->getConnection();
        $this->em   = $objDB->getEntityManager(array('src/Entity'),$config['db']);
        $this->logger= $mocker->getLoggerMock();
    }
    /**
     * Get TotalCurrentUsers
     */
    public function testGetUsers()
    {
        $userDao        = new UserDao($this->em, $this->logger);
        $totalUsuarios  = $userDao->getAll();
        $this->assertCount(0, $totalUsuarios);
    }
    public function testNewUsers()
    {
        $userDao        = new UserDao($this->em, $this->logger);
        $user           = new User();
        $info           = $userDao->createUser($user);
        $this->assertTrue(!$info);
    }
}