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
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Zend\Log\Logger;
use \Rioxygen\Zf2AuthCore\Service\UserService;
use \DateTime;
use \Bootstrap;

/**
 * Class to test User Service
 * @version 1.0
 */
class UserServiceTest extends PHPUnit_Framework_TestCase
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
     *
     * @var RoleTruncate
     */
    private $roleTruncate;
    /**
     *
     * @var UserDao 
     */
    private $userDao;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config                 = Bootstrap::getConfig();
        $mocker                 = new Mocker();
        $this->truncate         = new UserTruncate();
        $this->roleTruncate     = new RoleTruncate();
        $objDB                  = new Database($config['db']['host'], 
                $config['db']['dbname'], 
                $config['db']['user'], 
                $config['db']['password']);
        $this->pdo              = $objDB->getConnection();
        $this->em               = $objDB->getEntityManager(array('src/Entity'),$config['db']);
        $this->logger           = $mocker->getLoggerMock();
        $this->userDao          = new UserDao($this->em, $this->logger);
    }
    public function testGetAll()
    {
        $userService            = new UserService($this->userDao, $this->logger);
        $userService->getAll();
        $this->assertTrue(TRUE);
    }
    /**
     * Create User
     */
    public function testCreateUser()
    {
        $create                 = new DateTime("NOW");
        $userService            = new UserService($this->userDao, $this->logger);
        $user                   = new User();
            $user->setCreate($create);
            $user->setUpdated($create);
            $user->setDisplayName("Ricardo Ruiz");
            $user->setUsername("kasparov");
            $user->setPassword("unam2010");
            $user->setState(1);
            $user->setEmail("rrcfesc@gmail.com");
        $status                = $userService->create($user);
        $userFind               = $userService->findByEmail("rrcfesc@gmail.com");
        $this->assertEquals($user, $userFind);
        $this->assertTrue($status);
    }
    /**
     * Create User
     */
    public function testCreateUserFail()
    {
        $userService            = new UserService($this->userDao, $this->logger);
        $user                   = new User();
        $status                = $userService->create($user);
        $this->assertTrue(!$status);
    }
    /**
     * Create User
     */
    public function testDeleteUser()
    {
        $create                 = new DateTime("NOW");
        $userService            = new UserService($this->userDao, $this->logger);
        $user                   = new User();
            $user->setCreate($create);
            $user->setUpdated($create);
            $user->setDisplayName("Ricardo Ruiz");
            $user->setUsername("kasparov");
            $user->setPassword("unam2010");
            $user->setState(1);
            $user->setEmail("rrcfesc@gmail.com");
        $status                 = $userService->create($user);
        $this->assertTrue($status);
        $statusD                = $userService->delete($user);
        $this->assertTrue($statusD);
    }
    /**
     * Create User
     */
    public function testCreateUserFindById()
    {
        $create                 = new DateTime("NOW");
        $userService            = new UserService($this->userDao, $this->logger);
        $user                   = new User();
            $user->setCreate($create);
            $user->setUpdated($create);
            $user->setDisplayName("Ricardo Ruiz");
            $user->setUsername("kasparov");
            $user->setPassword("unam2010");
            $user->setState(1);
            $user->setEmail("rrcfesc@gmail.com");
        $status                = $userService->create($user);
        $userFind               = $userService->getById(1);
        $this->assertEquals($user, $userFind);
        $this->assertTrue($status);
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncate->userTable());
        $this->pdo->exec($this->roleTruncate->roleTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}