<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;

use Follower\CoreBundle\Interfaces\FollowInterface;
use Follower\TwitterBundle\Parser\ProfileParser;
use Follower\TwitterBundle\Service\AbstractService;
use Symfony\Component\BrowserKit\Response;

class Profile extends AbstractService
{
    public function profile($userName)
    {
        $result = $this->client->request('GET', $this->getProfileUrl($userName), array(), array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        return ProfileParser::parseUserInfo($result);
    }

    public function getTweets($userName) {
        $result = $this->client->request('GET', $this->getProfileUrl($userName), array(), array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        return ProfileParser::parseTweets($result);
    }
}