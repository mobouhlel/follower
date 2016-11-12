<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 11/11/16
 * Time: 21:57
 */

namespace Follower\TwitterBundle\Traits;

use Symfony\Component\BrowserKit\CookieJar;

trait RequestTrait
{
    /** @var  CookieJar */
    protected $cookieJar;

    /**
     * @return CookieJar
     */
    protected function getCookieJar() {
        if(file_exists($this->getCookieFilePath()) && $cookieJar = file_get_contents($this->getCookieFilePath()))
            return unserialize($cookieJar);

        $this->cookieJar = new CookieJar();

        return $this->cookieJar;
    }

    private function getCookieFilePath() {
        return __DIR__.  '/../../../../app/logs/twitter_cookie.tmp';
    }

    protected function saveCookie() {
        file_put_contents($this->getCookieFilePath(), serialize($this->cookieJar));
    }
}