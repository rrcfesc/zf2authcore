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
use Rioxygen\Zf2AuthCore\Utils\UserTruncate;
use Zend\Log\Logger;
use \DateTime;
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
     * @var UserTruncate
     */
    private $truncate;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config     = Bootstrap::getConfig();
        $mocker     = new Mocker();
        $this->truncate = new UserTruncate();
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
    /**
     * Fail to create new User
     */
    public function testFailNewUsers()
    {
        $userDao            = new UserDao($this->em, $this->logger);
        $user               = new User();
        $info               = $userDao->createUser($user);
        $this->assertTrue(!$info);
        $totalUsuarios      = $userDao->getAll();
        $this->assertCount(0, $totalUsuarios);
    }
    /**
     * Create new User
     */
    public function testNewUsers()
    {
        $create             = new DateTime("NOW");
        $userDao            = new UserDao($this->em, $this->logger);
        $user               = new User();
            $user->setCreate($create);
            $user->setUpdated($create);
            $user->setDisplayName("Ricardo Ruiz");
            $user->setUsername("kasparov");
            $user->setPassword("unam2010");
            $user->setState(1);
            $user->getEmail("rrcfesc@gmail.com");
        $info               = $userDao->createUser($user);
        $this->assertTrue($info);
        $this->assertTrue(!is_null($user->getId()));
        $totalUsuarios      = $userDao->getAll();
        $this->assertTrue((1 === $totalUsuarios->count()));
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncate->userTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}