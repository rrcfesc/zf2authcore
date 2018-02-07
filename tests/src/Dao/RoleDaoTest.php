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
use Rioxygen\Zf2AuthCore\Dao\RoleDao;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Zend\Log\Logger;
use \DateTime;
use \Bootstrap;

class RoleDaoTest extends PHPUnit_Framework_TestCase
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
        $this->truncate = new RoleTruncate();
        $objDB      = new Database($config['db']['host'], 
                $config['db']['dbname'], 
                $config['db']['user'], 
                $config['db']['password']);
        $this->pdo  = $objDB->getConnection();
        $this->em   = $objDB->getEntityManager(array('src/Entity'),$config['db']);
        $this->logger= $mocker->getLoggerMock();
    }
    /**
     * Get Total Roles
     */
    public function testGetRoles()
    {
        $roleDao        = new RoleDao($this->em, $this->logger);
        $totalRole      = $roleDao->getAll();
        $this->assertCount(0, $totalRole);
    }
    /**
     * TestCreateRole Fail
     */
    public function testCreateRoleNewFail()
    {
        $roleDao            = new RoleDao($this->em, $this->logger);
        $role               = new Role();
        $info               = $roleDao->createRole($role);
        $this->assertTrue(!$info);
    }
    /**
     * TestCreateRole
     */
    public function testCreateRoleNew()
    {
        $roleDao            = new RoleDao($this->em, $this->logger);
        $role               = new Role();
            $role->setState(1);
            $role->setRoleId("Test");
            $role->setId(10);
        $info               = $roleDao->createRole($role);
        $this->evaluteRole($role);
        $this->assertTrue($info);
    }
    /**
     * TestCreateRole
     */
    public function testCreateDeleteRoleNew()
    {
        $roleDao            = new RoleDao($this->em, $this->logger);
        $role               = new Role();
            $role->setState(1);
            $role->setRoleId("Test");
            $role->setId(10);
        $info               = $roleDao->createRole($role);
        $this->evaluteRole($role);
        $this->assertTrue($info);
        $delinfo            = $roleDao->deleteRole($role);
        $this->assertTrue($delinfo);
    }
    /**
     * Evaluete Role
     * @param Role $role
     */
    public function evaluteRole(Role $role)
    {
        $this->assertNotNull($role->getId());
        $this->assertNotNull($role->getRoleId());
        $this->assertNotNull($role->getState());
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncate->roleTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}