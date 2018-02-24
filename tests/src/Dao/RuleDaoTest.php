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
use Rioxygen\Zf2AuthCore\Dao\RuleDao;
use Rioxygen\Zf2AuthCore\Dao\ResourceDao;
use Rioxygen\Zf2AuthCore\Dao\RoleDao;
use Rioxygen\Zf2AuthCore\Entity\Rule;
use Rioxygen\Zf2AuthCore\Entity\Role;
use Rioxygen\Zf2AuthCore\Entity\Resource;
use Rioxygen\Zf2AuthCore\Utils\RuleTruncate;
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Rioxygen\Zf2AuthCore\Utils\ResourceTruncate;
use Zend\Log\Logger;
use \Bootstrap;


/**
 * Class to test Rule
 * @version 1.0
 */
class RuleDaoTest extends PHPUnit_Framework_TestCase
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
     * @var RuleTruncate
     */
    private $truncate;
    /**
     * @var RoleTruncate
     */
    private $truncateRole;
    /**
     * @var ResourceTruncate
     */
    private $truncateResource;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config                 = Bootstrap::getConfig();
        $mocker                 = new Mocker();
        $this->truncate         = new RuleTruncate();
        $this->truncateRole     = new RoleTruncate();
        $this->truncateResource = new ResourceTruncate();
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
    public function testGetRule()
    {
        $ruleDao                = new RuleDao($this->em, $this->logger);
        $totalRole              = $ruleDao->getAll();
        $this->assertCount(0, $totalRole);
    }
    public function testCreateRule()
    {
        $ruleDao                = new RuleDao($this->em, $this->logger);
        $role                   = $this->createRole();
        $resource               = $this->createResource();
        $rule                   = new Rule();
            $rule->setResource($resource);
            $rule->setRole($role);
            $rule->setPrivilege("Algo");
        $estatus = $ruleDao->create($rule);
        $this->assertTrue($estatus);
        $this->validateRule($rule);
        $this->assertTrue(true);
    }
    /**
     * 
     */
    public function testCreateRuleFail()
    {
        $ruleDao                = new RuleDao($this->em, $this->logger);
        $role                   = $this->createRole();
        $rule                   = new Rule();
            $rule->setRole($role);
            $rule->setPrivilege("Algo");
        $estatus = $ruleDao->create($rule);
        $this->assertTrue(!$estatus);
    }
    public function testDeleRule()
    {
        $ruleDao                = new RuleDao($this->em, $this->logger);
        $role                   = $this->createRole();
        $resource               = $this->createResource();
        $rule                   = new Rule();
            $rule->setResource($resource);
            $rule->setRole($role);
            $rule->setPrivilege("Algo");
        $estatus                = $ruleDao->create($rule);
        $this->assertTrue($estatus);
        $this->validateRule($rule);
        $estatusD               = $ruleDao->delete($rule);
        $this->assertTrue($estatusD);
    }
    public function testDeleRuleFail()
    {
        $ruleDao                = new RuleDao($this->em, $this->logger);
        $role                   = $this->createRole();
        $resource               = $this->createResource();
        $rule                   = new Rule();
            $rule->setResource($resource);
            $rule->setRole($role);
            $rule->setPrivilege("Algo");
        $estatus                = $ruleDao->create($rule);
        $this->assertTrue($estatus);
        $this->validateRule($rule);
        $rule->setPrivilege(null);
        $estatusD               = $ruleDao->delete($rule);
        //$this->assertTrue(!$estatusD);
    }
    /**
     * Create Role
     * @return Role
     */
    private function createRole() : Role
    {
        $roleDao                = new RoleDao($this->em, $this->logger);
        $role                   = new Role();
            $role->setState(0);
            $role->setRoleId("Basic");
            $role->setParent(null);
        $roleDao->create($role);
        return $role;
    }
    /**
     * Create Resource
     * @return Resource
     */
    private function createResource() : Resource
    {
        $resourceDao                = new ResourceDao($this->em, $this->logger);
        $resourceEntity             = new Resource();
        $resourceEntity->setDescription("Description");
        $resourceEntity->setName("Name");
        $resourceDao->create($resourceEntity);
        return $resourceEntity;
    }
    /**
     * Validate Rule and Contains
     * @param Rule $rule
     */
    private function validateRule(Rule $rule, $validate = true)
    {
        if ($validate) {
            $this->assertTrue(!is_null($rule->getId()));
        }
        $this->assertTrue(is_string($rule->getPrivilege()));
        $this->assertInstanceOf('Rioxygen\Zf2AuthCore\Entity\Role', $rule->getRole());
        $this->assertInstanceOf('Rioxygen\Zf2AuthCore\Entity\Resource', $rule->getResource());
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncateRole->roleTable());
        $this->pdo->exec($this->truncateResource->resourceTable());
        $this->pdo->exec($this->truncate->ruleTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}