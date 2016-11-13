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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Message extends AbstractService
{

    CONST SUCCESS_STATUS = 'following';

    public function send($userId, $message,  $extras = [])
    {
        $formData = array(
            'authenticity_token' => $this->getCookieJar()->get('auth_token')->getValue(),
            'conversation_id' => $userId . '-' . $this->container->getParameter('twitter_id'),
            'tagged_users' => null,
            'text' => $message,
            'tweetboxId' => 'swift_tweetbox_' . (new \DateTime())->getTimestamp() . rand(100, 999),
        );

        $this->client->setHeader('accept', 'application/json, text/javascript, */*; q=0.01');
        $this->client->setHeader('accept-encoding', 'gzip, deflate, br');
        $this->client->setHeader('accept-language', 'en-US,en;q=0.8,tr;q=0.6');
        $this->client->setHeader('content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
//        $this->client->setHeader('referer', $referer);
        $this->client->setHeader('user-agent', $this->getUserAgent());
        $this->client->setHeader('x-requested-with', 'XMLHttpRequest');

        $this->client->request('POST',$this->getMessageUrl(), $formData, array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        /** @var Response $response */
        $response = $this->client->getResponse();

        json_decode($response->getContent(), true);

        if($response->getStatus() != 200)
            throw new BadRequestHttpException(
                'Invalid response code: ' . $response->getStatus() . ', headers: ' . json_encode($response->getHeaders())
            );
        return true;
    }
}