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
use Follower\TwitterBundle\Service\Factory\Profile;
use Follower\TwitterBundle\Service\Factory\ReShare;
use Follower\TwitterBundle\Service\Factory\Search;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ReSharer
 * @package Follower\TwitterBundle\Service
 */
class ReSharer
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

        $this->wrapper = $container->get('core_reshare_wrapper');
    }

    public function share()
    {
        /** @var Provider $provider */
        $provider = $this->wrapper->getProvider(1);

        $users = $this->wrapper->getUsers($provider['id']);

        /** @var ReShare $reShare */
        $reShare = $this->getReShareFactory();

        /** @var Profile $profileFactory */
        $profileFactory = $this->getProfileFactory();

        while (true) {
            foreach ($users as $user) {
                try {
                    $result = $profileFactory->getTweets($user['username']);

                    $result = $result->toArray();
                    /** @var Item $item */
                    foreach ($result as $index => $item) {
                        $item = array_shift($result);

                        if(!$item->isShared() && $index < 3) {
                            if($reShare->share($item->getItemId(), $item->getExtra())) {
                                $this->container->get('follower_event_dispatcher')->dispatchReShared((new Event())
                                    ->setProviderId(1)
                                    ->setProviderName('Twitter')
                                    ->setStatus(true)
                                    ->setTransctionType(Event::TRANSACTION_LIKE)
                                    ->setData(array(
                                        'item_id' => $item->getItemId(),
                                        'item_text' => $item->getContent(),
                                        'user_entity_id' => $user['id'],
                                        'user_id' => $item->getUserId(),
                                        'user_name' => $item->getUserName()
                                    ))
                                );
                            } else {
                                $this->container->get('follower_event_dispatcher')->dispatchReShareFailed((new Event())
                                    ->setProviderId(1)
                                    ->setProviderName('Twitter')
                                    ->setStatus(false)
                                    ->setTransctionType(Event::TRANSACTION_LIKE)
                                    ->setData(array(
                                        'item_id' => $item->getItemId(),
                                        'item_text' => $item->getContent(),
                                        'user_id' => $item->getUserId(),
                                        'user_name' => $item->getUserName()
                                    ))
                                );
                            }

                            $this->wrapper->sleep(60);
                        } else {
                            $this->container->get('follower_event_dispatcher')->dispatchReSharedAlready((new Event())
                                ->setProviderId(1)
                                ->setProviderName('Twitter')
                                ->setStatus(true)
                                ->setTransctionType(Event::TRANSACTION_LIKE)
                                ->setData(array(
                                    'item_id' => $item->getItemId(),
                                    'item_text' => $item->getContent(),
                                    'user_id' => $item->getUserId(),
                                    'user_name' => $item->getUserName()
                                ))
                            );
                        }
                    }
                } catch ( BadRequestHttpException $err) {
                    var_dump($err->getMessage());
                    $this->wrapper->sleep(60*60*6);
                } catch ( \Exception $err) {
                    var_dump($err->getMessage());
                }
            }

            $this->wrapper->sleep(60*10);
        }
    }

    /**
     * @return Factory\Follow|object
     */
    public function getProfileFactory() {
        return $this->container->get('twitter_profile_factory');
    }

    /**
     * @return Factory\Follow|object
     */
    public function getReShareFactory() {
        return $this->container->get('twitter_reshare_factory');
    }
}