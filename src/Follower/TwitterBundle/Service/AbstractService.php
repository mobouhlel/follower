<?php

namespace Follower\TwitterBundle\Service;

use Follower\CoreBundle\Event\Event;
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

    public $token;

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
        if ($this->loggedIn()) {
            $this->container->get('follower_event_dispatcher')->dispatchAlreadyLoggedIn((new Event())
                ->setProviderId(1)
                ->setProviderName('Twitter')
                ->setStatus(true)
                ->setTransctionType(Event::TRANSACTION_LOGIN)
                ->setData(array())
            );

            return true;
        }

        $crawler = $this->client->request('GET', $this->getLoginUrl());

        if ($crawler->selectButton("Giriş yap")->count()) {
            $loginForm = $crawler->selectButton("Giriş yap")->form(array(
                'session[username_or_email]' => $this->getUsername(),
                'session[password]' => $this->getPassword()
            ));
        } elseif ($crawler->selectButton("Inloggen")->count()) {
            $loginForm = $crawler->selectButton("Inloggen")->form(array(
                'session[username_or_email]' => $this->getUsername(),
                'session[password]' => $this->getPassword()
            ));
        } else {
            throw new \Exception('Login form not found');
        }

        $result = $this->client->submit($loginForm);

        if (!$this->loggedIn($result->html())) {
            $this->container->get('follower_event_dispatcher')->dispatchLoginFailed((new Event())
                ->setProviderId(1)
                ->setProviderName('Twitter')
                ->setStatus(false)
                ->setTransctionType(Event::TRANSACTION_LOGIN)
                ->setData(array())
            );

            throw new \Exception('Login failed');
        } else {
            $this->container->get('follower_event_dispatcher')->dispatchLoggedIn((new Event())
                ->setProviderId(1)
                ->setProviderName('Twitter')
                ->setStatus(true)
                ->setTransctionType(Event::TRANSACTION_LOGIN)
                ->setData(array())
            );
        }

        $this->saveCookie();
    }

    /**
     * prepare token. Firstly, find init.js current version.
     * After, find token from init.js file.
     * Finally, Token prepared.
     */
    public function setToken($response)
    {
        preg_match_all('/https:\/\/abs.twimg.com\/k\/(.*)init(.*).js/i', $response, $matches);

        $link = current(current($matches));

        $guzzleClient = new \GuzzleHttp\Client();

        $response = $guzzleClient->get($link)->getBody()->getContents();

        preg_match_all('/var i=\"(.*)\";t.default/i', $response, $matches);

        $this->token = 'Bearer ' . current($matches[1]);
    }

    protected function loggedIn($response = null)
    {
        if (!$response)
            $response = $this->client->request('GET', $this->getBaseUrl())->html();

        $this->setToken($response);

        return preg_match('/signout-form/', $response);
    }
}