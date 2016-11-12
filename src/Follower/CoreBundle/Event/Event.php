<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 02:11
 */

namespace Follower\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event as ExtendedEvent;

class Event extends ExtendedEvent
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData($key = null)
    {
        if($key)
            return isset($this->data[$key]) ? $this->data[$key] : null;

        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}