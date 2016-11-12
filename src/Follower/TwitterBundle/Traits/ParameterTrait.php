<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 11/11/16
 * Time: 20:41
 */

namespace Follower\TwitterBundle\Traits;


use Symfony\Component\DependencyInjection\Container;

trait ParameterTrait
{
    protected function getUsername()
    {
        return $this->container->getParameter('twitter_username');
    }

    protected function getPassword()
    {
        return $this->container->getParameter('twitter_password');
    }
}