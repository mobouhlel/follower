<?php

namespace Follower\CoreBundle\Wrapper;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 12:19
 */
class UnfollowerWrapper extends AbstractWapper
{
    public function getFollows($providerId) {
        return $this->connection->fetchAll('select * from follow where provider_id = ? and followed = ?', array(
            $providerId, true
        ), array(
            \PDO::PARAM_INT, \PDO::PARAM_BOOL
        ));
    }
}