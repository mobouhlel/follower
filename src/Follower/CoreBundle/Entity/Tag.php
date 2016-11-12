<?php

namespace Follower\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Follower\CoreBundle\Repository\TagRepository")
 */
class Tag
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
     * @ORM\ManyToOne(targetEntity="Provider", inversedBy="tags")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id")
     */
    private $provider;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = true;

    /**
     * @ORM\OneToMany(targetEntity="Follow", mappedBy="tag")
     */
    private $follows;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return Tag
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
     * Set status
     *
     * @param boolean $status
     * @return Tag
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set provider
     *
     * @param \Follower\CoreBundle\Entity\Provider $provider
     * @return Tag
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
     * Add follows
     *
     * @param \Follower\CoreBundle\Entity\Follow $follows
     * @return Tag
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
}
