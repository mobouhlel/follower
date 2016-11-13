<?php

namespace Follower\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Like
 *
 * @ORM\Table(name="likes")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Follower\CoreBundle\Repository\LikeRepository")
 */
class Like
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
     * @ORM\ManyToOne(targetEntity="Provider", inversedBy="likes")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id")
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="likes")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=TRUE)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="item_id", type="string", length=255, nullable=TRUE)
     */
    private $itemId;

    /**
     * @var string
     *
     * @ORM\Column(name="item_text", type="string", length=255, nullable=TRUE)
     */
    private $itemText;

    /**
     * @var string
     *
     * @ORM\Column(name="user_id", type="string", length=255, nullable=TRUE)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=255, nullable=TRUE)
     */
    private $userName;

    /**
     * @var bool
     *
     * @ORM\Column(name="liked", type="boolean", nullable=true)
     */
    private $liked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

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
     * Set itemId
     *
     * @param string $itemId
     * @return Like
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return string 
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set itemText
     *
     * @param string $itemText
     * @return Like
     */
    public function setItemText($itemText)
    {
        $this->itemText = $itemText;

        return $this;
    }

    /**
     * Get itemText
     *
     * @return string 
     */
    public function getItemText()
    {
        return $this->itemText;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Like
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return Like
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set liked
     *
     * @param boolean $liked
     * @return Like
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * Get liked
     *
     * @return boolean 
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Like
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Like
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set provider
     *
     * @param \Follower\CoreBundle\Entity\Provider $provider
     * @return Like
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
     * Set tag
     *
     * @param \Follower\CoreBundle\Entity\Tag $tag
     * @return Like
     */
    public function setTag(\Follower\CoreBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \Follower\CoreBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
