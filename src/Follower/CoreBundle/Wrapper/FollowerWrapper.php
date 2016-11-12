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
    public function getActiveTags($providerId) {
        return $this->connection->fetchAll('select * from tag where provider_id = ? and status = ?', array(
            $providerId, true
        ), array(
            \PDO::PARAM_INT, \PDO::PARAM_BOOL
        ));
    }

    public function isFollowed($providerId, $username, $userId) {
        $result = $this->connection->fetchAssoc(
            'select * from follow where follow.provider_id = ? and (follow.user = ? or follow.user = ?)', array(
            $providerId, $userId, $username
        ), array(
            \PDO::PARAM_INT, \PDO::PARAM_STR, \PDO::PARAM_STR
        ));

        return !empty($result);
    }
}