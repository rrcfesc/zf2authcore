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
use Rioxygen\Zf2AuthCore\Dao\RoleDao;
use Rioxygen\Zf2AuthCore\Entity\User;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Rioxygen\Zf2AuthCore\Utils\UserTruncate;
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Zend\Log\Logger;
use \DateTime;
use \Bootstrap;


/**
 * Class to test User
 * @version 1.0
 */
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
     *
     * @var RoleTruncate
     */
    private $roleTruncate;
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
        $info               = $userDao->create($user);
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
            $user->setEmail("rrcfesc@gmail.com");
        $info               = $userDao->create($user);
        $this->assertTrue($info);
        $this->assertUser($user);
        $this->assertTrue(!is_null($user->getId()));
        $totalUsuarios      = $userDao->getAll();
        $this->assertTrue((1 === count($totalUsuarios)));
        return $user;
    }
    /**
     * 
     * @depends testNewUsers
     */
    public function testDeleteUser($user)
    {
        $userDao            = new UserDao($this->em, $this->logger);
        $userDao->delete($user);
        $totalUsuarios      = $userDao->getAll();
        $this->assertTrue((0 === $totalUsuarios->count()));
    }
    /**
     * Create new User
     */
    public function testNewUsersSearch()
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
            $user->setEmail("rrcfesc@gmail.com");
        $info               = $userDao->create($user);
        $this->assertTrue($info);
        $this->assertUser($user);
        $this->assertTrue(!is_null($user->getId()));
        $totalUsuarios      = $userDao->getAll();
        $this->assertTrue((1 === count($totalUsuarios)));
        return $user;
    }
    /**
     * @depends testNewUsersSearch
     */
    public function testUserGetById(User $user)
    {
        $create             = new DateTime("NOW");
        $userDao            = new UserDao($this->em, $this->logger);
        $userCreate         = new User();
            $userCreate->setId(100);
            $userCreate->setCreate($create);
            $userCreate->setUpdated($create);
            $userCreate->setDisplayName("Ricardo Ruiz");
            $userCreate->setUsername("kasparov");
            $userCreate->setPassword("unam2010");
            $userCreate->setState(1);
            $userCreate->setEmail("rrcfesc@gmail.com");
        $info               = $userDao->create($userCreate);
        $this->assertTrue($info);
        $this->assertUser($userCreate);
        $userSearch         = $userDao->getById($user->getId());
        $this->assertEquals($userSearch->getId(), $user->getId());
        return $user;
    }
    /**
     * 
     * @param User $user
     */
    public function testUserGetByIdNF()
    {
        //$create             = new DateTime("NOW");
        $userDao            = new UserDao($this->em, $this->logger);
        $userSearch         = $userDao->getById(10000);
        $this->assertTrue((is_null($userSearch->getId())));
    }
    
    /**
     * Create new User With Role
     */
    public function testNewUsersRole()
    {
        $roleDao            = new RoleDao($this->em, $this->logger);
        $userDao            = new UserDao($this->em, $this->logger);
        $create             = new DateTime("NOW");
        $user               = new User();
            $user->setCreate($create);
            $user->setUpdated($create);
            $user->setDisplayName("Ricardo Ruiz");
            $user->setUsername("kasparov");
            $user->setPassword("unam2010");
            $user->setState(1);
            $user->setEmail("rrcfesc@gmail.com");
        $infoU              = $userDao->create($user);
        $role               = new Role();
            $role->setState(1);
            $role->setRoleId("Test");
            $role->setId(10);
        $infoR              = $roleDao->create($role);
        $this->assertTrue($infoU);
        $this->assertTrue($infoR);
        $user->addRole($role);
        $userDao->create($user);
        $this->assertUser($user);
        $this->assertUserRoles($user, 1);
        $user->removeRole($role);
        $userDao->create($user);
        $this->assertUserRoles($user, 0);
    }
    /**
     * Test Fail Delete User
     */
    public function testDeleteFailUser()
    {
        $userDao            = new UserDao($this->em, $this->logger);
        $user               = new User();
        $info               = $userDao->delete($user);
        $this->assertTrue(!$info);
    }
    /**
     * AssertInfoUser
     * @param User $user
     */
    public function assertUser(User $user)
    {
        $this->assertNotNull($user->getId());
        $this->assertNotNull($user->getCreate());
        $this->assertNotNull($user->getDisplayName());
        $this->assertNotNull($user->getState());
        $this->assertNotNull($user->getUpdated());
        $this->assertNotNull($user->getPassword());
        $this->assertNotNull($user->getRoles());
        $this->assertNotNull($user->getArrayCopy());
        $this->assertNotNull($user->getUsername());
        $this->assertNotNull($user->getEmail());
    }
    /**
     * Evaluate how many Role has the user
     * @param User $user
     * @param Integer $amount
     */
    public function assertUserRoles(User $user, $amount = 1)
    {
        $roles = $user->getRoles();
        $this->assertCount($amount, $roles);
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