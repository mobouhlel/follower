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
use Follower\CoreBundle\Event\Event;
use Follower\CoreBundle\Helper\TimeHelper;
use Follower\CoreBundle\Schema\Item;
use Follower\CoreBundle\Wrapper\FollowerWrapper;
use Follower\TwitterBundle\Service\Factory\Follow;
use Follower\TwitterBundle\Service\Factory\Like;
use Follower\TwitterBundle\Service\Factory\Search;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

        $this->wrapper = $container->get('core_follower_wrapper');
    }

    public function follow()
    {
        /** @var Provider $provider */
        $provider = $this->wrapper->getProvider(1);

        $tags = $this->wrapper->getActiveTags($provider['id']);

        $sleepTime = TimeHelper::calculateSleepTime($provider['daily_follow']);

        /** @var Search $followFactory */
        $searchFactory = $this->getSearchFactory();

        /** @var Follow $followFactory */
        $followFactory = $this->getFollowFactory();

        while (true) {
            foreach ($tags as $tag) {
                try {
                    $result = $searchFactory->search($tag['name']);

                    /** @var Item $item */
                    foreach ($result as $item) {
                        if($item->isFollowing() || $this->wrapper->isFollowed($provider['id'], $item->getUserId(), $item->getUserName())) {
                            $this->container->get('follower_event_dispatcher')->dispatchFollowedAlready((new Event())
                                ->setProviderId(1)
                                ->setProviderName('Twitter')
                                ->setStatus(true)
                                ->setTransctionType(Event::TRANSACTION_FOLLOW)
                                ->setData(array(
                                    'tag_id' => $tag['id'],
                                    'tag_name' => $tag['name'],
                                    'user_id' => $item->getUserId(),
                                    'user_name' => $item->getUserName()
                                ))
                            );
                            continue;
                        }

                        if($followFactory->follow($item->getUserId())) {
                            $this->container->get('follower_event_dispatcher')->dispatchFollowed((new Event())
                                ->setProviderId(1)
                                ->setProviderName('Twitter')
                                ->setStatus(true)
                                ->setTransctionType(Event::TRANSACTION_FOLLOW)
                                ->setData(array(
                                    'tag_id' => $tag['id'],
                                    'tag_name' => $tag['name'],
                                    'user_id' => $item->getUserId(),
                                    'user_name' => $item->getUserName()
                                ))
                            );
                        } else {
                            $this->container->get('follower_event_dispatcher')->dispatchFollowed((new Event())
                                ->setProviderId(1)
                                ->setProviderName('Twitter')
                                ->setStatus(false)
                                ->setTransctionType(Event::TRANSACTION_FOLLOW)
                                ->setData(array(
                                    'tag_id' => $tag['id'],
                                    'tag_name' => $tag['name'],
                                    'user_id' => $item->getUserId(),
                                    'user_name' => $item->getUserName()
                                ))
                            );
                        }

                        $this->wrapper->sleep($sleepTime);
                    }
                } catch ( BadRequestHttpException $err) {
                    var_dump($err->getMessage());
                    $this->wrapper->sleep(60*60*6);
                } catch ( \Exception $err) {
                    var_dump($err->getMessage());
                }
            }

            $this->wrapper->sleep(60*60*1);
        }
    }

    /**
     * @return Factory\Search|object
     */
    public function getSearchFactory() {
        return $this->container->get('twitter_search_factory');
    }

    /**
     * @return Factory\Follow|object
     */
    public function getFollowFactory() {
        return $this->container->get('twitter_follow_factory');
    }
}