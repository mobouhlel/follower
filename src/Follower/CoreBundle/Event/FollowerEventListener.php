<?php

namespace Follower\CoreBundle\Event;

use Doctrine\DBAL\Connection;
use Follower\CoreBundle\Logger\CommandLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FollowerEventListener implements EventSubscriberInterface
{
    const STARTED = "started";

    const FOLLOWED = "followed";
    const UNFOLLOWED = "unfollowed";
    const LIKED = "liked";
    const RESHARED = "reshared";
    const UNLIKED = "unliked";
    const MESSAGE_SENT = "message_sent";

    const MESSAGE_SEND_FAILED = "message_send_failed";
    const FOLLOW_FAILED = "follow_failed";
    const UNFOLLOW_FAILED = "unfollow_failed";
    const LIKE_FAILED = "like_failed";
    const RESHARE_FAILED = "reshare_failed";
    const UNLIKE_FAILED = "unlike_failed";

    const FOLLOWED_ALREADY = "follower_already";
    const UNFOLLOWED_ALREADY = "unfollowed_already";
    const LIKED_ALREADY = "liked_already";
    const RESHARED_ALREADY = "reshared_already";
    const UNLIKED_ALREADY = "unliked_already";
    const MESSAGE_SENT_ALREADY = "message_sent_already";

    const ALREADY_LOGGED_IN = "already_logged_in";
    const LOGIN_SUCCESS = "login_success";
    const LOGIN_FAILURE = "login_failed";
    const SEARCH_SUCCESS = "search_success";

    /** @var  Connection $connection */
    protected $connection;

    /** @var  CommandLogger $logger */
    protected $logger;

    /**
     * FollowerEventListener constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->logger = new CommandLogger();
    }


    public static function getSubscribedEvents()
    {
        return array(
            self::STARTED => array('onStarted', 0),

            self::FOLLOWED => array('onFollowed', 0),
            self::UNFOLLOWED => array('onUnfollowed', 0),
            self::LIKED => array('onLiked', 0),
            self::UNLIKED => array('onUnliked', 0),
            self::RESHARED => array('onReShared', 0),
            self::MESSAGE_SENT => array('onMessageSent', 0),

            self::FOLLOW_FAILED => array('onFollowFailed', 0),
            self::UNFOLLOW_FAILED => array('onUnfollowFailed', 0),
            self::LIKE_FAILED => array('onLikeFailed', 0),
            self::UNLIKE_FAILED => array('onUnlikeFailed', 0),
            self::RESHARE_FAILED => array('onReShareFailed', 0),
            self::MESSAGE_SEND_FAILED => array('onMessageSendFailed', 0),

            self::ALREADY_LOGGED_IN => array('onAlreadyLoggedIn', 0),
            self::LOGIN_SUCCESS => array('onLoginSuccess', 0),
            self::LOGIN_FAILURE => array('onLoginFailed', 0),
            self::SEARCH_SUCCESS => array('onSearchSuccess', 0),

            self::FOLLOWED_ALREADY => array('onFollowedAlready', 0),
            self::UNFOLLOWED_ALREADY => array('onUnfollowedAlready', 0),
            self::LIKED_ALREADY => array('onLikedAlready', 0),
            self::RESHARED_ALREADY => array('onReSharedAlready', 0),
            self::UNLIKED_ALREADY => array('onUnLikedAlready', 0),
            self::MESSAGE_SENT_ALREADY => array('onMessageSentAlready', 0),
        );
    }

    /**
     * @param Event $event
     */
    public function onFollowed(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);

        $this->connection->insert('follow', array(
            'provider_id' => $event->getProviderId(),
            'tag_id' => $event->getData('tag_id'),
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'followed' => true,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Event $event
     */
    public function onFollowFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);

        $this->connection->insert('follow', array(
            'provider_id' => $event->getProviderId(),
            'tag_id' => $event->getData('tag_id'),
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'followed' => false,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Event $event
     */
    public function onUnfollowed(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);

        $this->connection->update('follow', array(
            'blocked' => true
        ), array(
            'id' => $event->getData('id')
        ));
    }

    /**
     * @param Event $event
     */
    public function onUnfollowFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onLiked(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);

        $this->connection->insert('likes', array(
            'provider_id' => $event->getProviderId(),
            'tag_id' => $event->getData('tag_id'),
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'liked' => true,
            'item_id' => $event->getData('item_id'),
            'item_text' => $event->getData('item_text'),
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Event $event
     */
    public function onLikeFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);

        $this->connection->insert('likes', array(
            'provider_id' => $event->getProviderId(),
            'tag_id' => $event->getData('tag_id'),
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'liked' => false,
            'item_id' => $event->getData('item_id'),
            'item_text' => $event->getData('item_text'),
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Event $event
     */
    public function onReShared(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);

        $this->connection->insert('re_share', array(
            'user_id' => $event->getData('user_entity_id'),
            'status' => true,
            'provider_id' => $event->getProviderId(),
            'created_at' => date('Y-m-d H:i:s'),
            'item_id' => $event->getData('item_id')
        ));
    }

    /**
     * @param Event $event
     */
    public function onReShareFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);

        $this->connection->insert('re_share', array(
            'user_id' => $event->getData('user_entity_id'),
            'status' => func_get_args(),
            'provider_id' => $event->getProviderId(),
            'created_at' => date('Y-m-d H:i:s'),
            'item_id' => $event->getData('item_id')
        ));
    }

    /**
     * @param Event $event
     */
    public function onUnliked(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onUnlikeFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onStarted(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onAlreadyLoggedIn(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onLoginSuccess(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onLoginFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onSearchSuccess(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onFollowedAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onUnfollowedAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onLikedAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onReSharedAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onMessageSent(Event $event)
    {
        $this->log('success', __FUNCTION__, $event);

        $this->connection->insert('message', array(
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'provider_id' => $event->getProviderId(),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => true,
            'message' => $event->getData('message')
        ));
    }

    /**
     * @param Event $event
     */
    public function onMessageSendFailed(Event $event)
    {
        $this->log('error', __FUNCTION__, $event);

        $this->connection->insert('message', array(
            'user_id' => $event->getData('user_id'),
            'user_name' => $event->getData('user_name'),
            'provider_id' => $event->getProviderId(),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => false,
            'message' => $event->getData('message')
        ));
    }

    /**
     * @param Event $event
     */
    public function onUnLikedAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }

    /**
     * @param Event $event
     */
    public function onMessageSentAlready(Event $event)
    {
        $this->log('info', __FUNCTION__, $event);
    }


    public function log($level, $method, Event $event) {
        $providerName = $event->getProviderName();

        $this->logger->$level("[$providerName][$method]", $event->getData());
    }
}