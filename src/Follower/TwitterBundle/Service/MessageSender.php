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
use Follower\TwitterBundle\Service\Factory\Message;
use Follower\TwitterBundle\Service\Factory\Profile;
use Follower\TwitterBundle\Service\Factory\Search;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class MessageSender
 * @package Follower\TwitterBundle\Service
 */
class MessageSender
{
    /** @var  Container $container */
    protected $container;

    /** @var  EntityManager $em */
    protected $em;

    /** @var  MessageSender $wrapper */
    protected $wrapper;

    /**
     * DailyFollower constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->em = $container->get('doctrine.orm.entity_manager');

        $this->wrapper = $container->get('core_message_wrapper');
    }

    public function send()
    {
        /** @var Provider $provider */
        $provider = $this->wrapper->getProvider(1);

        /** @var Message $followFactory */
        $messageFactory = $this->getMessageSenderFactory();

        /** @var Profile $followFactory */
        $profileFactory = $this->getProfileFactory();


        $message = 'Bizi takip ettiğiniz için teşekkür ederiz. ';

        while (true) {
            $followers = $profileFactory->getFollowers('ultraultraslan1');
            /** @var Item $follower */
            foreach ($followers as $follower) {
                try {
                    if ($this->wrapper->sendBefore($provider['id'], $follower->getUserId(), $follower->getUserName())) {
                        $this->container->get('follower_event_dispatcher')->dispatchMessageSentAlready((new Event())
                            ->setProviderId(1)
                            ->setProviderName('Twitter')
                            ->setStatus(true)
                            ->setTransctionType(Event::TRANSACTION_MESSAGE)
                            ->setData(array(
                                'user_id' => $follower->getUserId(),
                                'user_name' => $follower->getUserName()
                            ))
                        );
                        continue;
                    }

                    if ($messageFactory->send($follower->getUserId(), $message)) {
                        $this->container->get('follower_event_dispatcher')->dispatchMessageSent((new Event())
                            ->setProviderId(1)
                            ->setProviderName('Twitter')
                            ->setStatus(true)
                            ->setTransctionType(Event::TRANSACTION_MESSAGE)
                            ->setData(array(
                                'user_id' => $follower->getUserId(),
                                'user_name' => $follower->getUserName()
                            ))
                        );
                    } else {
                        $this->container->get('follower_event_dispatcher')->dispatchMessageSendFailed((new Event())
                            ->setProviderId(1)
                            ->setProviderName('Twitter')
                            ->setStatus(false)
                            ->setTransctionType(Event::TRANSACTION_MESSAGE)
                            ->setData(array(
                                'user_id' => $follower->getUserId(),
                                'user_name' => $follower->getUserName()
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

            $this->wrapper->sleep(60*60*1);
        }
    }

    /**
     * @return Factory\Message|object
     */
    public function getMessageSenderFactory() {
        return $this->container->get('twitter_messagesend_factory');
    }

    /**
     * @return Factory\Profile|object
     */
    public function getProfileFactory() {
        return $this->container->get('twitter_profile_factory');
    }
}