<?php

namespace Follower\TwitterBundle\Service;
use Follower\TwitterBundle\Traits\ParameterTrait;
use Follower\TwitterBundle\Traits\RequestTrait;
use Follower\TwitterBundle\Traits\UrlTrait;
use Goutte\Client;
use Symfony\Component\DependencyInjection\Container;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:01
 */
class AbstractService
{
    use UrlTrait;

    use ParameterTrait;

    use RequestTrait;

    /** @var Container $container */
    protected $container;

    /** @var  Client $client */
    protected $client;

    /**
     * AbstractService constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->client = new Client([], null, $this->getCookieJar());

        $this->client->setHeader('User-Agent', $this->getUserAgent());
    }


    public function login()
    {
        if ($this->loggedIn())
            return true;

        $crawler = $this->client->request('GET', $this->getLoginUrl());

        $loginForm = $crawler->selectButton("Giriş yap")->form(array(
            'session[username_or_email]' => $this->getUsername(),
            'session[password]' => $this->getPassword()
        ));

        $result = $this->client->submit($loginForm);

        if(!$this->loggedIn($result->html()))
            throw new \Exception('Login failed');

        $this->saveCookie();
    }

    protected function loggedIn($response = null)
    {
        if (!$response)
            $response = $this->client->request('GET', $this->getBaseUrl())->html();

        return preg_match('/signout-form/', $response);
    }
}