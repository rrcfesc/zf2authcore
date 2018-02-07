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
use Rioxygen\Zf2AuthCore\Dao\ControllerGuardDao;
use Rioxygen\Zf2AuthCore\Entity;
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Rioxygen\Zf2AuthCore\Utils\ControllerGuardTruncate;
use Zend\Log\Logger;
use \Bootstrap;

class ControllerGuardDaoTest extends PHPUnit_Framework_TestCase
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
     * @var ControllerGuardTruncate
     */
    private $truncateCGTruncate;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config             = Bootstrap::getConfig();
        $mocker             = new Mocker();
        $this->truncate     = new RoleTruncate();
        $this->truncateCGTruncate = new ControllerGuardTruncate();
        $objDB              = new Database($config['db']['host'], 
                $config['db']['dbname'], 
                $config['db']['user'], 
                $config['db']['password']);
        $this->pdo          = $objDB->getConnection();
        $this->em           = $objDB->getEntityManager(array('src/Entity'),$config['db']);
        $this->logger       = $mocker->getLoggerMock();
    }
    /**
     * Get ControllerGuard
     */
    public function testGetAllControllerGuard()
    {
        $controlerGDao              = new ControllerGuardDao($this->em, $this->logger);
        $totalControlerGDao         = $controlerGDao->getAll();
        $this->assertCount(0, $totalControlerGDao);
    }
    /**
     * Test Fail Create
     */
    public function testCreateControllerGuard()
    {
        $controllerGDao             = new ControllerGuardDao($this->em, $this->logger);
        $controllerG                = new Entity\ControllerGuard();
            $controllerG->setId(1);
            $controllerG->setController("Application\\Controller\\Index");
            $controllerG->setAction("Read");
        $info                       = $controllerGDao->createControllerGuard($controllerG);
        $this->assertTrue($info);
        $this->assertControllerGuard($controllerG, true);
    }
    /**
     * Test Create Remove
     */
    public function testCreateControllerGuardRoleAddRemove()
    {
        #create Role
        $roleDao            = new RoleDao($this->em, $this->logger);
        $role               = new Entity\Role();
            $role->setState(1);
            $role->setRoleId("Test");
            $role->setId(10);
        $roleDao->createRole($role);
        #create 
        $controllerGDao             = new ControllerGuardDao($this->em, $this->logger);
        $controllerG                = new Entity\ControllerGuard();
            $controllerG->setId(1);
            $controllerG->setController("Application\\Controller\\Index");
            $controllerG->setAction("Read");
            $controllerG->addRoles($role);
        $info                       = $controllerGDao->createControllerGuard($controllerG);
        $this->assertTrue($info);
        $this->assertControllerGuard($controllerG, true);
        $controllerG->removeRole($role);
        $infoA                      = $controllerGDao->createControllerGuard($controllerG);
        $this->assertTrue($infoA);
        $this->assertControllerGuard($controllerG, true);
        $infoDel                    = $controllerGDao->deleteControllerGuard($controllerG);
        $this->assertTrue($infoDel);
    }
    /**
     * Test Create Remove
     */
    public function testCreateCGRoleAddRemoveF()
    {
        #create Role
        $roleDao            = new RoleDao($this->em, $this->logger);
        $role               = new Entity\Role();
            $role->setState(1);
            $role->setRoleId("Test");
            $role->setId(1000);
        $roleDao->createRole($role);
        #create 
        $controllerGDao             = new ControllerGuardDao($this->em, $this->logger);
        $controllerG                = new Entity\ControllerGuard();
            $controllerG->setId(1);
            $controllerG->setController("Application\\Controller\\Index");
            $controllerG->setAction("Read");
        $info                       = $controllerGDao->createControllerGuard($controllerG);
        $this->assertTrue($info);
        $this->assertControllerGuard($controllerG, true);
        $controllerG->removeRole($role);
        $infoA                      = $controllerGDao->createControllerGuard($controllerG);
        $this->assertTrue($infoA);
    }
    /**
     * Verify information ControllerGuard
     * @param \Rioxygen\Zf2AuthCore\Entity\ControllerGuard $controllerGuard
     * @param bool $verify
     */
    public function assertControllerGuard(Entity\ControllerGuard $controllerGuard, $verify = false)
    {
        $this->assertNotNull($controllerGuard->getController());
        $this->assertNotNull($controllerGuard->getAction());
        if ($verify === TRUE) {
            $this->assertNotNull($controllerGuard->getId());
        }
        $roles = $controllerGuard->getRoles();
        foreach ($roles as $rol) {
            $this->assertInstanceOf("Rioxygen\Zf2AuthCore\Entity\Role", $rol);
        }
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncate->roleTable());
        $this->pdo->exec($this->truncateCGTruncate->ControllerGuardTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}