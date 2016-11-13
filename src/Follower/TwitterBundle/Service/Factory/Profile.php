<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Follower\CoreBundle\Interfaces\FollowInterface;
use Follower\TwitterBundle\Parser\ProfileParser;
use Follower\TwitterBundle\Service\AbstractService;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\DomCrawler\Crawler;

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

    public function getFollowers($userName) {
        $result = $this->client->request('GET', $this->getFollowersUrl(), array(), array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));


        /** @var ArrayCollection $followers */
        list($followers, $maxPosition) = ProfileParser::parseFollowers($result);

        $nextUrl = $this->getFollowersPaginationUrl($userName, $maxPosition);

        while (true) {
            $this->client->request('GET', $nextUrl, array(), array(), array(
                'HTTP_USER_AGENT' => $this->getUserAgent()
            ));

            $result = json_decode($this->client->getResponse()->getContent(), true);

            /** @var ArrayCollection $newFollowers */
            list($newFollowers, $maxPosition) = ProfileParser::parseFollowers(new Crawler($result['items_html']));

            $followers = new ArrayCollection(array_merge($followers->toArray(), $newFollowers->toArray()));

            if($result['has_more_items'] == false)
                break;

            $nextUrl = $this->getFollowersPaginationUrl($userName, $result['min_position']);
        }

        return $followers;
    }
}