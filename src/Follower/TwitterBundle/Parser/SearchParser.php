<?php

namespace Follower\TwitterBundle\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use Follower\CoreBundle\Schema\Item;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 00:56
 */
class SearchParser
{
    static function parse(Crawler $crawler) {
        $result = new ArrayCollection();

        $crawler->filter('.stream-items > li')->each(function (Crawler $node) use ($result) {
            if ($node->filter('.ProfileCard-bio ')->count()) {
//                $result->add((new Item())
//                    ->setContent($node->filter('.ProfileCard-bio ')->first()->text())
//                    ->setFollowing($node->filter('.user-actions-follow-button')->count() == 0)
//                    ->setFollowingBack(null)
//                    ->setIsTweet(false)
//                    ->setIsUser(true)
//                    ->setUserId($node->filter('.ProfileCard')->first()->attr('data-user-id'))
//                    ->setUserName($node->filter('.ProfileCard')->first()->attr('data-screen-name'))
//                );
            } elseif ($node->filter('.tweet-text')->count()) {
                $result->add((new Item())
                    ->setContent($node->filter('.tweet-text')->first()->text())
                    ->setFollowing($node->filter('.js-stream-tweet')->first()->attr('data-you-follow') == "true")
                    ->setFollowingBack($node->filter('.js-stream-tweet')->first()->attr('data-follows-you') == "true")
                    ->setIsTweet(true)
                    ->setIsUser(false)
                    ->setUserId($node->filter('.js-stream-tweet')->first()->attr('data-user-id'))
                    ->setUserName($node->filter('.js-stream-tweet')->first()->attr('data-screen-name'))
                );
            }
        });

        return $result;
    }
}