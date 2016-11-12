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
use Follower\TwitterBundle\Service\Factory\Follow;
use Follower\TwitterBundle\Service\Factory\Search;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class Follower
 * @package Follower\TwitterBundle\Service
 */
class Follower
{
    /** @var  Container $container */
    protected $container;

    /** @var  EntityManager $em */
    protected $em;

    /**
     * DailyFollower constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function follow()
    {
        /** @var Provider $provider */
        $provider = $this->em->getRepository('FollowerCoreBundle:Provider')->findOneBy(array('id' => 1));

        $sleepTime = TimeHelper::calculateSleepTime($provider->getDailyFollow());

        var_dump("sleep time: ". $sleepTime);
        /** @var Search $followFactory */
        $searchFactory = $this->getSearchFactory();

        /** @var Follow $followFactory */
        $followFactory = $this->getFollowFactory();

        while (true) {
            foreach ($provider->getTags() as $tag) {
                try {
                    $result = $searchFactory->search($tag->getName());

                    /** @var Item $item */
                    foreach ($result as $item) {
                        if($item->isFollowing())
                            continue;

                        $status = $followFactory->follow($item->getUserId());

                        $this->container->get('follower_event_dispatcher')->dispatchFollowed(array(
                            'followed' => $status,
                            'provider_id' => $provider->getId(),
                            'tag_id' => $tag->getId(),
                            'user' => $item->getUserName() ? $item->getUserName() : $item->getUserId()
                        ));

                        var_dump(array(
                            'followed' => $status,
                            'provider_id' => $provider->getId(),
                            'tag_id' => $tag->getId(),
                            'user' => $item->getUserName() ? $item->getUserName() : $item->getUserId()
                        ));

                        sleep($sleepTime);
                    }
                } catch ( \Exception $err) {
                    var_dump($err->getMessage());
                }
            }
        }
    }

    /**
     * @return Factory\Search|object
     */
    public function getSearchFactory() {
        return $this->container->get('twitter_search');
    }

    /**
     * @return Factory\Follow|object
     */
    public function getFollowFactory() {
        return $this->container->get('twitter_follow');
    }
}