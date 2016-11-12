<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;


use Follower\CoreBundle\Interfaces\UnfollowInterface;
use Follower\TwitterBundle\Service\AbstractService;

class Unfollow extends AbstractService implements UnfollowInterface
{
    public function unfollow($userId)
    {
        // TODO: Implement unfollow() method.
    }
}