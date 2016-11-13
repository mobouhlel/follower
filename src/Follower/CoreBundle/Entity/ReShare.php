<?php

namespace Follower\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReShare
 *
 * @ORM\Table(name="re_share")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Follower\CoreBundle\Repository\ReShareRepository")
 */
class ReShare
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Provider")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id")
     */
    private $provider;


    /**
     * @ORM\ManyToOne(targetEntity="ReShare")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status = false;

    /**
     * @var int
     *
     * @ORM\Column(name="item_id", type="string", length=255)
     */
    private $itemId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ReShare
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return ReShare
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ReShare
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set provider
     *
     * @param \Follower\CoreBundle\Entity\Provider $provider
     * @return ReShare
     */
    public function setProvider(\Follower\CoreBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \Follower\CoreBundle\Entity\Provider 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Set user
     *
     * @param \Follower\CoreBundle\Entity\ReShare $user
     * @return ReShare
     */
    public function setUser(\Follower\CoreBundle\Entity\ReShare $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Follower\CoreBundle\Entity\ReShare 
     */
    public function getUser()
    {
        return $this->user;
    }
}
