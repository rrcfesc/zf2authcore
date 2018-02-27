<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\DaoFactory;

use Rioxygen\Zf2AuthCore\Dao\UserDao;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserDaoFactory
 * @version 1.0
 */
class UserDaoFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserDao
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em             = $serviceLocator->get("Doctrine\ORM\EntityManager");
        $logger         = $serviceLocator->get("Zend\Log\Logger");
        $userDAO        = new UserDao($em, $logger);
        return $userDAO;
    }
}