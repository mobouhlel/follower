<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;


use Follower\CoreBundle\Interfaces\LikeInterface;
use Follower\TwitterBundle\Service\AbstractService;
use Symfony\Component\BrowserKit\Response;

class Like extends AbstractService implements LikeInterface
{

    CONST SUCCESS_STATUS = 'following';

    public function like($shareId, $extras = [])
    {
        $formData = array(
            'authenticity_token' => $this->getCookieJar()->get('auth_token')->getValue(),
            'id' => $shareId,
            'tweet_stat_count' => $extras['tweet_stat_count']
        );

        $this->client->setHeader('accept', 'application/json, text/javascript, */*; q=0.01');
        $this->client->setHeader('accept-encoding', 'gzip, deflate, br');
        $this->client->setHeader('accept-language', 'en-US,en;q=0.8,tr;q=0.6');
        $this->client->setHeader('content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
//        $this->client->setHeader('referer', $referer);
        $this->client->setHeader('user-agent', $this->getUserAgent());
        $this->client->setHeader('x-requested-with', 'XMLHttpRequest');

        $this->client->request('POST',$this->getLikeUrl(), $formData, array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        /** @var Response $response */
        $response = $this->client->getResponse();

        json_decode($response->getContent(), true);

        return true;
    }
}