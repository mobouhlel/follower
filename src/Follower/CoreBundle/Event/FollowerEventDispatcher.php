<?php

namespace Follower\CoreBundle\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FollowerEventDispatcher
{
    /**@var EventDispatcherInterface $dispatcher */
    protected $dispatcher;

    /**
     * EventDispatcher constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatchStarted(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::STARTED, $event);
    }

    public function dispatchFollowed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::FOLLOWED, $event);
    }

    public function dispatchUnfollowed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNFOLLOWED, $event);
    }

    public function dispatchLiked(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LIKED, $event);
    }

    public function dispatchReShared(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::RESHARED, $event);
    }

    public function dispatchUnliked(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNLIKED, $event);
    }

    public function dispatchFollowFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::FOLLOW_FAILED, $event);
    }

    public function dispatchUnfollowFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNFOLLOW_FAILED, $event);
    }

    public function dispatchLikeFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LIKE_FAILED, $event);
    }

    public function dispatchReShareFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::RESHARE_FAILED, $event);
    }

    public function dispatchUnlikeFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNLIKE_FAILED, $event);
    }

    public function dispatchAlreadyLoggedIn(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::ALREADY_LOGGED_IN, $event);
    }

    public function dispatchLoggedIn(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LOGIN_SUCCESS, $event);
    }

    public function dispatchLoginFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LOGIN_FAILURE, $event);
    }

    public function dispatchSearchSuccess(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::SEARCH_SUCCESS, $event);
    }

    public function dispatchFollowedAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::FOLLOWED_ALREADY, $event);
    }

    public function dispatchUnfollowedAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNFOLLOWED_ALREADY, $event);
    }

    public function dispatchLikedAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LIKED_ALREADY, $event);
    }

    public function dispatchReSharedAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::RESHARED_ALREADY, $event);
    }

    public function dispatchUnlikedAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNLIKED_ALREADY, $event);
    }

    public function dispatchMessageSent(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::MESSAGE_SENT, $event);
    }

    public function dispatchMessageSendFailed(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::MESSAGE_SEND_FAILED, $event);
    }

    public function dispatchMessageSentAlready(Event $event)
    {
        $this->dispatcher->dispatch(FollowerEventListener::MESSAGE_SENT_ALREADY, $event);
    }
}