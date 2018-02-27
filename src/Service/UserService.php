<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Service;

use Rioxygen\Zf2AuthCore\Dao\UserDao;
use Psr\Log\LoggerInterface;
use Rioxygen\Zf2AuthCore\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use \Exception;

/**
 * Class UserService
 * @version 1.0
 */
class UserService
{
    /**
     * @var UserDao
     */
    private $userDao;
    /**
     * @var LoggerInterface 
     */
    private $logger;
    /**
     * Constructor
     * @param UserDAO $userDao DAO
     * @param LoggerInterface $logger Logger
     */
    public function __construct(UserDAO $userDao, LoggerInterface $logger)
    {
        $this->userDao      = $userDao;
        $this->logger       = $logger;
    }
    /**
     * Get all
     * @param int $page
     * @param int $items
     * @param int $state
     * @return Paginator
     */
    public function getAll($page = 0, $items = 100, $state = 1) : Paginator
    {
        $response           = $this->userDao->getAll($page, $items, $state);
        return $response;
    }
    /**
     * Create / Update
     * @param User $user
     * @return bool
     */
    public function create(User $user) :bool
    {
        try {
            $response           = $this->userDao->create($user);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            $response           = false;
        }
        return $response;
    }
    /**
     * Create / Update
     * @param User $user
     * @return bool
     */
    public function delete(User $user) :bool
    {
        try {
            $response           = $this->userDao->delete($user);
        } catch (Exception $ex) {
            $response           = false;
            $this->logger->error($ex->getMessage());
        }
        return $response;
    }
    /**
     * Find User By Id
     * @param int $id
     * @return User
     */
    public function getById(int $id) : User
    {
        $response       = $this->userDao->findOneBy(array('id' => $id));
        return $response;
    }
    /**
     * Find by email
     * @param string $email
     * @return User
     */
    public function findByEmail($email) : User
    {
        $response       = $this->userDao->findOneBy(array('email' => $email));
        return $response;
    }
}