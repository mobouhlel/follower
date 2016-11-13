<?php

namespace Follower\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="Follower\CoreBundle\Repository\ProviderRepository")
 */
class Provider
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_like", type="integer")
     */
    private $dailyLike;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_follow", type="integer")
     */
    private $dailyFollow;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_unfollow", type="integer")
     */
    private $dailyUnfollow;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="provider")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Like", mappedBy="provider")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="Follow", mappedBy="provider")
     */
    private $follows;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->follows = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Provider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Provider
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dailyLike
     *
     * @param integer $dailyLike
     * @return Provider
     */
    public function setDailyLike($dailyLike)
    {
        $this->dailyLike = $dailyLike;

        return $this;
    }

    /**
     * Get dailyLike
     *
     * @return integer 
     */
    public function getDailyLike()
    {
        return $this->dailyLike;
    }

    /**
     * Set dailyFollow
     *
     * @param integer $dailyFollow
     * @return Provider
     */
    public function setDailyFollow($dailyFollow)
    {
        $this->dailyFollow = $dailyFollow;

        return $this;
    }

    /**
     * Get dailyFollow
     *
     * @return integer 
     */
    public function getDailyFollow()
    {
        return $this->dailyFollow;
    }

    /**
     * Set dailyUnfollow
     *
     * @param integer $dailyUnfollow
     * @return Provider
     */
    public function setDailyUnfollow($dailyUnfollow)
    {
        $this->dailyUnfollow = $dailyUnfollow;

        return $this;
    }

    /**
     * Get dailyUnfollow
     *
     * @return integer 
     */
    public function getDailyUnfollow()
    {
        return $this->dailyUnfollow;
    }

    /**
     * Add tags
     *
     * @param \Follower\CoreBundle\Entity\Tag $tags
     * @return Provider
     */
    public function addTag(\Follower\CoreBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Follower\CoreBundle\Entity\Tag $tags
     */
    public function removeTag(\Follower\CoreBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection | Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add follows
     *
     * @param \Follower\CoreBundle\Entity\Follow $follows
     * @return Provider
     */
    public function addFollow(\Follower\CoreBundle\Entity\Follow $follows)
    {
        $this->follows[] = $follows;

        return $this;
    }

    /**
     * Remove follows
     *
     * @param \Follower\CoreBundle\Entity\Follow $follows
     */
    public function removeFollow(\Follower\CoreBundle\Entity\Follow $follows)
    {
        $this->follows->removeElement($follows);
    }

    /**
     * Get follows
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollows()
    {
        return $this->follows;
    }

    /**
     * Add likes
     *
     * @param \Follower\CoreBundle\Entity\Like $likes
     * @return Provider
     */
    public function addLike(\Follower\CoreBundle\Entity\Like $likes)
    {
        $this->likes[] = $likes;

        return $this;
    }

    /**
     * Remove likes
     *
     * @param \Follower\CoreBundle\Entity\Like $likes
     */
    public function removeLike(\Follower\CoreBundle\Entity\Like $likes)
    {
        $this->likes->removeElement($likes);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
