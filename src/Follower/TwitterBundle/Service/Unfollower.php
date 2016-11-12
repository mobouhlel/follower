<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:43
 */

namespace Follower\TwitterBundle\Service;


use Symfony\Component\DependencyInjection\Container;

class Unfollower
{
    /** @var  Container $container */
    protected $container;

    /**
     * DailyFollower constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


}