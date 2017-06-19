<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;


use Follower\CoreBundle\Interfaces\FollowInterface;
use Follower\TwitterBundle\Service\AbstractService;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Follow extends AbstractService implements FollowInterface
{
    CONST SUCCESS_STATUS = 'following';
    CONST HEADER_BLOCKED= '400 Bad Request';

    public function follow($userId)
    {
        $formData = array(
            'challenges_passed' => false,
            'handles_challenges' => true,
            'include_blocked_by' => true,
            'include_blocking' => true,
            'include_followed_by' => true,
            'include_can_dm' => true,
            'include_mute_edge' => true,
            'skip_status' => true,
            'user_id' => $userId
        );

        $this->client->setHeader('accept', 'application/json, text/javascript, */*; q=0.01');
        $this->client->setHeader('accept-encoding', 'gzip, deflate, br');
        $this->client->setHeader('accept-language', 'en-US,en;q=0.8,tr;q=0.6');
        $this->client->setHeader('content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
//        $this->client->setHeader('referer', $referer);
        $this->client->setHeader('user-agent', $this->getUserAgent());
        $this->client->setHeader('x-twitter-active-user', 'yes');
        $this->client->setHeader('x-twitter-auth-type', 'OAuth2Session');
        $this->client->setHeader('authorization', $this->token);
        $this->client->setHeader('x-csrf-token', $this->getCookieJar()->get('ct0')->getValue());

        $this->client->request('POST',$this->getFollowUrl(), $formData, array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        /** @var Response $response */
        $response = $this->client->getResponse();

        if($response->getHeader('status') === self::HEADER_BLOCKED) {
            var_dump($response->getContent());

            throw new BadRequestHttpException(self::HEADER_BLOCKED);
        }

        if($response->getStatus() != 200) {
            var_dump($response->getContent());

            throw new BadRequestHttpException(
                'Invalid response codes: ' . $response->getStatus() . ', headers: ' . json_encode($response->getHeaders())
            );
        }


        $result = json_decode($response->getContent(), true);

        if(isset($result['new_state']) && $result['new_state'] === self::SUCCESS_STATUS)
            return true;

        return false;
    }
}