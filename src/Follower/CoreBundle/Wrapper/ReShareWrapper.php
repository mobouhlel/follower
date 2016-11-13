<?php

namespace Follower\CoreBundle\Wrapper;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 12:19
 */
class ReShareWrapper extends AbstractWapper
{
    public function getUsers($providerId) {
        return $this->connection->fetchAll('select * from re_share_user where active = ?', array(
            true
        ), array(
            \PDO::PARAM_BOOL
        ));
    }
}