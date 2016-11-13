<?php

namespace Follower\CoreBundle\Wrapper;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 12:19
 */
class MessageWrapper extends AbstractWapper
{
    public function sendBefore($providerId, $userId, $userName) {
        $result = $this->connection->fetchAssoc(
            'select * from message where provider_id = ? and (user_id = ? or user_name = ?)', array(
            $providerId, $userId, $userName
        ), array(
            \PDO::PARAM_INT, \PDO::PARAM_STR, \PDO::PARAM_STR
        ));

        return !empty($result);
    }
}