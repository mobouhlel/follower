<?php

namespace Follower\TwitterBundle\Traits;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 11/11/16
 * Time: 20:05
 */
/**
 * Class UrlTrait
 * @package Follower\TwitterBundle\Traits
 */
trait UrlTrait
{
    /**
     * @var string
     */
    private $base = 'https://twitter.com/';

    /**
     * @var string
     */
    private $login = 'https://twitter.com/login/';

    /**
     * @var string
     */
    private $search = 'https://twitter.com/search?q={query}';

    /**
     * @var string
     */
    private $follow = 'https://api.twitter.com/1.1/friendships/create.json';

    /**
     * @var string
     */
    private $unfollow = 'https://twitter.com/i/user/unfollow';

    /**
     * @var string
     */
    private $like = 'https://twitter.com/i/tweet/like';

    /**
     * @var string
     */
    private $profile = 'https://twitter.com/{username}';

    /**
     * @var string
     */
    private $message = 'https://twitter.com/i/direct_messages/new';

    /**
     * @var string
     */
    private $followers = 'https://twitter.com/followers';

    /**
     * @var string
     */
    private $followersPagination = 'https://twitter.com/{username}/followers/users?include_available_features=1&include_entities=1&max_position={max_position}&reset_error_state=false';

    /**
     * @var string
     */
    private $reshare = 'https://twitter.com/i/tweet/retweet';

    /**
     * @var string
     */
    private $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36';

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->base;
    }

    /**
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->login;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function getSearchUrl($query)
    {
        return str_replace("{query}", $query, $this->search);
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return string
     */
    public function getFollowUrl()
    {
        return $this->follow;
    }

    /**
     * @return string
     */
    public function getUnfollowUrl()
    {
        return $this->unfollow;
    }

    /**
     * @return string
     */
    public function getMessageUrl()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getLikeUrl()
    {
        return $this->like;
    }

    /**
     * @return string
     */
    public function getReShareUrl()
    {
        return $this->reshare;
    }

    /**
     * @return string
     */
    public function getFollowersUrl()
    {
        return $this->followers;
    }

    /**
     * @return string
     */
    public function getFollowersPaginationUrl($username, $maxPosition)
    {
        $url = str_replace("{username}", $username, $this->followersPagination);
        $url = str_replace("{max_position}", $maxPosition, $url);

        return $url;
    }

    /**
     * @return string
     */
    public function getProfileUrl($username)
    {
        return str_replace("{username}", $username, $this->profile);
    }
}