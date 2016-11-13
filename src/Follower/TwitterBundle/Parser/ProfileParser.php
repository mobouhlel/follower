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
class ProfileParser
{
    CONST FOLLOWING_BACK_STATUS = 'seni takip ediyor';

    static function parseUserInfo(Crawler $crawler) {
        $item = new Item();

        $actions = $crawler->filter('.ProfileNav-item--userActions > .UserActions > .user-actions')->first();

        $following = preg_match('/ following /', $actions->attr('class'));
        $canDM = preg_match('/can-dm/', $actions->attr('class'));
        $userId = $actions->attr('data-user-id');
        $userName = $actions->attr('data-screen-name');
        $followingBack = $crawler->filter('.FollowStatus')->count() && $crawler->filter('.FollowStatus')->text() === self::FOLLOWING_BACK_STATUS;

        $item
            ->setItemId(null)
            ->setUserName($userName)
            ->setLiked(false)
            ->setUserId($userId)
            ->setExtra(array('can_dm' => $canDM))
            ->setIsUser(true)
            ->setContent(null)
            ->setFollowing($following)
            ->setFollowingBack($followingBack)
            ->setIsTweet(false)
        ;

        return $item;
    }

    static function parseTweets(Crawler $crawler) {
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
                    ->setShared($node->filter('.js-stream-tweet')->first()->attr('data-my-retweet-id') !== null)
                    ->setUserId($node->filter('.js-stream-tweet')->first()->attr('data-user-id'))
                    ->setItemId($node->filter('.js-stream-tweet')->first()->attr('data-item-id'))
                    ->setUserName($node->filter('.js-stream-tweet')->first()->attr('data-screen-name'))
                    ->setLiked(
                        preg_match('/favorited/', $node->filter('.js-stream-tweet')->first()->attr('class'))
                    )->setExtra(array(
                        'tweet_like_stat_count' => $node->filter('.ProfileTweet-action--favorite')->first()->filter('.ProfileTweet-actionCount')->attr('data-tweet-stat-count'),
                        'tweet_share_stat_count' => $node->filter('.js-actionRetweet')->filter('.ProfileTweet-actionCountForPresentation')->text(),
                        'retweet_id' => $node->filter('.js-stream-tweet')->first()->attr('data-my-retweet-id'),
                    ))
                );
            }
        });

        return $result;
    }

    static function parseFollowers(Crawler $crawler) {
        $result = new ArrayCollection();

        $minPosition = $crawler->filter('.GridTimeline-items')->count() ?
            $crawler->filter('.GridTimeline-items')->attr('data-min-position') : null;

        $crawler->filter('.js-stream-item')->each(function (Crawler $node) use ($result) {
            $userId = $node->filter('.ProfileCard')->first()->attr('data-user-id');
            $userName = $node->filter('.ProfileCard')->first()->attr('data-screen-name');

            $result->add((new Item())
                ->setContent(null)
                ->setFollowing(null)
                ->setFollowingBack(true)
                ->setIsTweet(false)
                ->setIsUser(true)
                ->setShared(null)
                ->setUserId($userId)
                ->setItemId(null)
                ->setUserName($userName)
                ->setLiked(null)
                ->setExtra(array())
            );
        });

        return array($result, $minPosition);
    }
}