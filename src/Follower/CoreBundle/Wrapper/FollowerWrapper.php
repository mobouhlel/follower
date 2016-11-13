<?php

namespace Follower\CoreBundle\Wrapper;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 12:19
 */
class FollowerWrapper extends AbstractWapper
{
    public function isFollowed($providerId, $username, $userId) {
        $result = $this->connection->fetchAssoc(
            'select * from follow where follow.provider_id = ? and (follow.user_id = ? or follow.user_name = ?)', array(
            $providerId, $userId, $username
        ), array(
            \PDO::PARAM_INT, \PDO::PARAM_STR, \PDO::PARAM_STR
        ));

        return !empty($result);
    }
}