<?php
/**
 * Rioxygen
 * @license  BS3-Clausule
 * @author Ricardo Ruiz <rrcfesc@gmail.com>
 */
namespace Rioxygen\Zf2AuthCore\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Rioxygen\Zf2AuthCore\Entity\User;
use Psr\Log\LoggerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use \Exception;

/**
 * UserDao
 * @version 1.0
 */
class UserDao
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var RepositoryFactory
     */
    private $repository;
    /**
     * @var LoggerInterface 
     */
    private $logger;
    /**
     * Class construct
     * @param Doctrine\ORM\EntityManager $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em           = $em;
        $this->logger       = $logger;
        $this->repository   = $this->em->getRepository('Rioxygen\Zf2AuthCore\Entity\User');
    }
    /**
     * Determinate if we can create or update User
     * @param User $user
     * @return int
     */
    public function createUser(User $user) : int
    {
        $control = array(1);
        try {
            $this->em->persist($user);
            $this->em->flush();
            $control[] = true;
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            $control[] = false;
        }
        return (!in_array(0, $control));
    }
    /**
     * Get allUsers
     * @return ArrayCollection
     */
    public function getAll() : ArrayCollection
    {
        $respuesta = $this->repository->findAll();
        if (is_array($respuesta)) {
            $respuesta = new ArrayCollection();
        }
        return $respuesta;
    }
}