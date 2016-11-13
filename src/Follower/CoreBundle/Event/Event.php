<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 02:11
 */

namespace Follower\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event as ExtendedEvent;

/**
 * Class Event
 * @package Follower\CoreBundle\Event
 */
class Event extends ExtendedEvent
{
    CONST TRANSACTION_START = 'start';
    CONST TRANSACTION_LOGIN = 'login';
    CONST TRANSACTION_FOLLOW = 'follow';
    CONST TRANSACTION_UNFOLLOW = 'unfollow';
    CONST TRANSACTION_LIKE = 'like';
    CONST TRANSACTION_UNLIKE = 'unlike';
    CONST TRANSACTION_RESHARE = 'reshare';
    CONST TRANSACTION_MESSAGE = 'message';

    /**
     * @var integer
     */
    protected $providerId;

    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var string
     */
    protected $transctionType;

    /**
     * @var boolean
     */
    protected $status;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $data;

    /**
     * Event constructor.
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param mixed $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * @param mixed $providerName
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransctionType()
    {
        return $this->transctionType;
    }

    /**
     * @param mixed $transctionType
     */
    public function setTransctionType($transctionType)
    {
        $this->transctionType = $transctionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData($key = null)
    {
        if ($key)
            return isset($this->data[$key]) ? $this->data[$key] : null;

        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}