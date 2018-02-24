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
use Rioxygen\Zf2AuthCore\Dao\ResourceDao;
use Rioxygen\Zf2AuthCore\Entity;
use Rioxygen\Zf2AuthCore\Utils;
use Zend\Log\Logger;
use \Bootstrap;

class ResourceDaoTest extends PHPUnit_Framework_TestCase
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
     * @var Utils\ResourceTruncate
     */
    private $truncate;
    /**
     * Initial Setup
     */
    public function setUp()
    {
        $config             = Bootstrap::getConfig();
        $mocker             = new Mocker();
        $this->truncate     = new Utils\ResourceTruncate();
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
    public function testGetAllResoruce()
    {
        $resourceDao              = new ResourceDao($this->em, $this->logger);
        $totalResourceDao         = $resourceDao->getAll();
        $this->assertCount(0, $totalResourceDao);
    }
    /**
     * Get ControllerGuard
     */
    public function testCreateResource()
    {
        $resourceDao                = new ResourceDao($this->em, $this->logger);
        $resourceEntity             = new Entity\Resource();
        $resourceEntity->setDescription("Description");
        $resourceEntity->setName("Name");
        $resourceDao->create($resourceEntity);
        $this->resourceValidator($resourceEntity);
        $totalResourceDao           = $resourceDao->getAll();
        $this->assertCount(1, $totalResourceDao);
    }
    /**
     * Get ControllerGuard
     */
    public function testCreateFailResource()
    {
        $resourceDao                = new ResourceDao($this->em, $this->logger);
        $resourceEntity             = new Entity\Resource();
        $estatus                    = $resourceDao->create($resourceEntity);
        $this->assertTrue(!$estatus);
        
    }
    /**
     * Get ControllerGuard
     */
    public function testDeleteFailResource()
    {
        $resourceDao                = new ResourceDao($this->em, $this->logger);
        $resourceEntity             = new Entity\Resource();
        $resourceEntity->setDescription("Description");
        $resourceEntity->setName("Name");
        $resourceDao->create($resourceEntity);
        $this->resourceValidator($resourceEntity);
        $totalResourceDao           = $resourceDao->getAll();
        $this->assertCount(1, $totalResourceDao);
        $resourceEntity->setName(null);
        $resourceDao->delete($resourceEntity);
        $totalResourceDao2           = $resourceDao->getAll();
        $this->assertCount(1, $totalResourceDao2);
    }
    /**
     * Get ControllerGuard
     */
    public function testDeleteResource()
    {
        $resourceDao                = new ResourceDao($this->em, $this->logger);
        $resourceEntity             = new Entity\Resource();
        $resourceEntity->setDescription("Description");
        $resourceEntity->setName("Name");
        $resourceDao->create($resourceEntity);
        $this->resourceValidator($resourceEntity);
        $totalResourceDao           = $resourceDao->getAll();
        $this->assertCount(1, $totalResourceDao);
        $resourceDao->delete($resourceEntity);
        $totalResourceDao2           = $resourceDao->getAll();
        $this->assertCount(1, $totalResourceDao2);
    }
    /**
     * <p>Valida el entity</p>
     * @param \Rioxygen\Zf2AuthCore\Entity\Resource $resource
     * @param type $activo
     */
    private function resourceValidator(Entity\Resource $resource, $activo = true)
    {
        if ($activo) {
            $this->assertTrue(!is_null($resource->getId()));
            $this->assertTrue(!is_null($resource->getResourceId()));
        }
        $this->assertTrue(is_string($resource->getName()));
        $this->assertTrue(is_string($resource->getDescription()));
    }
    /**
     * Truncate Table
     */
    public function tearDown()
    {
        $this->pdo->exec($this->truncate->unChainFk());
        $this->pdo->exec($this->truncate->resourceTable());
        $this->pdo->exec($this->truncate->chainFk());
    }
}