<?php

namespace Follower\CoreBundle\Schema;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 11/11/16
 * Time: 23:13
 */
class Item
{
    /** @var  integer $userId */
    protected $userId;

    /** @var  integer $itemId */
    protected $itemId;

    /** @var  string $userName */
    protected $userName;

    /** @var  string $content */
    protected $content;

    /** @var  boolean $following */
    protected $following;

    /** @var  boolean $followingBack */
    protected $followingBack;

    /** @var  boolean $userIsFollowingBack */
    protected $isUser;

    /** @var  boolean $userIsFollowingBack */
    protected $isTweet;

    /** @var  boolean $liked */
    protected $liked;

    /** @var  boolean $shared */
    protected $shared;

    /** @var  array $extra */
    protected $extra;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFollowing()
    {
        return $this->following;
    }

    /**
     * @param boolean $following
     */
    public function setFollowing($following)
    {
        $this->following = $following;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFollowingBack()
    {
        return $this->followingBack;
    }

    /**
     * @param boolean $followingBack
     */
    public function setFollowingBack($followingBack)
    {
        $this->followingBack = $followingBack;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUser()
    {
        return $this->isUser;
    }

    /**
     * @param boolean $isUser
     */
    public function setIsUser($isUser)
    {
        $this->isUser = $isUser;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTweet()
    {
        return $this->isTweet;
    }

    /**
     * @param boolean $isTweet
     */
    public function setIsTweet($isTweet)
    {
        $this->isTweet = $isTweet;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isLiked()
    {
        return $this->liked;
    }

    /**
     * @param boolean $liked
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtra($key = null)
    {
        if($key)
            return isset($this->extra[$key]) ? $this->extra[$key] : null;

        return $this->extra;
    }

    /**
     * @param array $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @param boolean $shared
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }
}