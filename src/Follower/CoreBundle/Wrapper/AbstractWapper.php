<?php

namespace Follower\CoreBundle\Wrapper;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\Container;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 12:19
 */
abstract class AbstractWapper
{
    /** @var  Container $container */
    protected $container;

    /** @var  Connection $connection */
    protected $connection;

    /**
     * UnlikerWrapper constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->connection = $container->get('database_connection');
    }

    public function getProvider($id) {
        return $this->connection->fetchAssoc('select * from provider where id = ?', array(
            $id
        ), array(
            \PDO::PARAM_INT
        ));
    }
}