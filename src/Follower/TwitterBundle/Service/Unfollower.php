<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:43
 */

namespace Follower\TwitterBundle\Service;

use Doctrine\ORM\EntityManager;
use Follower\CoreBundle\Event\Event;
use Follower\CoreBundle\Wrapper\FollowerWrapper;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class Liker
 * @package Follower\TwitterBundle\Service
 */
class Unfollower
{
    CONST UNFOLLOW_AFTER = '+4 day';

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

        $this->wrapper = $container->get('core_unfollower_wrapper');
    }

    public function unfollow()
    {
        $followers = $this->wrapper->getFollows(1);

        $current = new \DateTime();

        while(true) {
            foreach ($followers as $follower) {
                try {
                    if (!$follower['user_name']) continue;

                    $unfollowTime = (new \DateTime($follower['createdAt']))->modify(self::UNFOLLOW_AFTER);

                    if ($current < $unfollowTime) continue;

                    $item = $this->getProfileFactory()->profile($follower['user_name']);

                    if ($item->isFollowingBack()) continue;

                    if(!$item->isFollowing()) continue;

                    if($this->getUnfollowFactory()->unfollow($item->getUserId())) {
                        $this->container->get('follower_event_dispatcher')->dispatchUnfollowed((new Event())
                            ->setProviderId(1)
                            ->setProviderName('Twitter')
                            ->setStatus(true)
                            ->setTransctionType(Event::TRANSACTION_UNFOLLOW)
                            ->setData(array(
                                'user_id' => $item->getUserId(),
                                'user_name' => $item->getUserName()
                            ))
                        );
                    } else {
                        $this->container->get('follower_event_dispatcher')->dispatchUnfollowFailed((new Event())
                            ->setProviderId(1)
                            ->setProviderName('Twitter')
                            ->setStatus(false)
                            ->setTransctionType(Event::TRANSACTION_UNFOLLOW)
                            ->setData(array(
                                'user_id' => $item->getUserId(),
                                'user_name' => $item->getUserName()
                            ))
                        );
                    }
                } catch (BadRequestHttpException $err) {
                    var_dump($err->getMessage());
                    $this->wrapper->sleep(60*60*6);
                } catch (\Exception $err) {
                    var_dump($err->getMessage());
                }

                $this->wrapper->sleep(60);
            }

            $this->wrapper->sleep(60*60*24);
        }
    }

    /**
     * @return Factory\Unfollow|object
     */
    public function getUnfollowFactory()
    {
        return $this->container->get('twitter_unfollow_factory');
    }

    /**
     * @return Factory\Profile|object
     */
    public function getProfileFactory()
    {
        return $this->container->get('twitter_profile_factory');
    }
}