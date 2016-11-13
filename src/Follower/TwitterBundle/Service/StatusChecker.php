<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:43
 */

namespace Follower\TwitterBundle\Service;

use Doctrine\ORM\EntityManager;
use Follower\CoreBundle\Entity\Provider;
use Follower\CoreBundle\Helper\TimeHelper;
use Follower\CoreBundle\Schema\Item;
use Follower\CoreBundle\Wrapper\FollowerWrapper;
use Follower\TwitterBundle\Service\Factory\Follow;
use Follower\TwitterBundle\Service\Factory\Like;
use Follower\TwitterBundle\Service\Factory\Search;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class Liker
 * @package Follower\TwitterBundle\Service
 */
class StatusChecker
{
    /** @var  Container $container */
    protected $container;

    /** @var  EntityManager $em */
    protected $em;

    /** @var  FollowerWrapper $wrapper */
    protected $wrapper;

    /**
     * DailyFollower constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->em = $container->get('doctrine.orm.entity_manager');

        $this->wrapper = $container->get('core_liker_wrapper');
    }

    public function check()
    {

    }

    /**
     * @return Factory\Search|object
     */
    public function getUnfollowFactory() {
        return $this->container->get('twitter_unfollow_factory');
    }

    /**
     * @return Factory\Follow|object
     */
    public function getProfileFactory() {
        return $this->container->get('twitter_profile_factory');
    }
}