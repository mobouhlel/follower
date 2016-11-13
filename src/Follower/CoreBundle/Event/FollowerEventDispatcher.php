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

    public function dispatchFollowed(array $data)
    {
        $this->dispatcher->dispatch(FollowerEventListener::FOLLOWED, (new Event($data)));
    }

    public function dispatchUnfollowed(array $data)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNFOLLOWED, (new Event($data)));
    }

    public function dispatchLiked(array $data)
    {
        $this->dispatcher->dispatch(FollowerEventListener::LIKED, (new Event($data)));
    }

    public function dispatchReShared(array $data)
    {
        $this->dispatcher->dispatch(FollowerEventListener::RESHARED, (new Event($data)));
    }

    public function dispatchUnliked(array $data)
    {
        $this->dispatcher->dispatch(FollowerEventListener::UNLIKED, (new Event($data)));
    }
}