<?php

namespace Follower\CoreBundle\Event;

use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FollowerEventListener implements EventSubscriberInterface
{
    const FOLLOWED = "followed";
    const UNFOLLOWED = "unfollowed";
    const LIKED = "liked";
    const UNLIKED = "unliked";

    /** @var  Connection $connection */
    protected $connection;

    /**
     * FollowerEventListener constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public static function getSubscribedEvents()
    {
        return array(
            self::FOLLOWED => array('onFollowed', 0),
            self::UNFOLLOWED => array('onUnfollowed', 0),
            self::LIKED => array('onLiked', 0),
            self::UNLIKED => array('onUnliked', 0)
        );
    }

    /**
     * @param Event $event
     */
    public function onFollowed(Event $event)
    {
        $this->connection->insert('follow', array(
            'provider_id' => $event->getData('provider_id'),
            'tag_id' => $event->getData('tag_id'),
            'user' => $event->getData('user'),
            'followed' => $event->getData('followed'),
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Event $event
     */
    public function onUnfollowed(Event $event)
    {

        var_dump(__METHOD__);
    }

    /**
     * @param Event $event
     */
    public function onLiked(Event $event)
    {

        var_dump(__METHOD__);
    }

    /**
     * @param Event $event
     */
    public function onUnliked(Event $event)
    {
        var_dump(__METHOD__);
    }
}