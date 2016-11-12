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
    private $follow = 'https://twitter.com/i/user/follow';

    /**
     * @var string
     */
    private $profile = 'https://twitter.com/{username}';

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
    public function getProfile($username)
    {
        return str_replace("{username}", $username, $this->profile);
    }
}