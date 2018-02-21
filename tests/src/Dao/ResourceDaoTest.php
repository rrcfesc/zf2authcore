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
use Rioxygen\Zf2AuthCore\Utils\RoleTruncate;
use Rioxygen\Zf2AuthCore\Utils\ControllerGuardTruncate;
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
    public function testGetAllResoruce()
    {
        $resourceDao              = new ResourceDao($this->em, $this->logger);
        $totalResourceDao         = $resourceDao->getAll();
        $this->assertCount(0, $totalResourceDao);
    }
}