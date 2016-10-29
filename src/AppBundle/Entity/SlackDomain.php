<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * SlackDomain
 *
 * @ORM\Table(name="slack_domain")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SlackDomainRepository")
 */
class SlackDomain
{   

    public function __construct( $domain)
    {
        $this->domain = $domain;
    }



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
     * @ORM\Column(name="domain", type="string", length=255, unique=true)
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="updated", type="datetime")
    */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="PointHistory", mappedBy="domain")
     */
    private $pointHistory;

    /**
    * @ORM\OneToMany(targetEntity="Person", mappedBy="domain")
    */
    private $people;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return SlackDomain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return SlackDomain
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

        /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return SlackDomain
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Get pointHistory
     * @return array PointHistory
     */
    public function getPointHistory()
    {
        return $this->pointHistory;
    }


    /**
     * Get pointHistory
     * @return array PointHistory
     */
    public function getPeople()
    {
        return $this->People;
    }


    /**
   * Set revision on update
   *
   * @ORM\PreUpdate
   */
    public function preUpdate()
    {
        $this->setUpdated(new \DateTime());
    }


    /**
    * @ORM\PrePersist
    */
    public function prePersist() {
        if( empty($this->created) ) {
            $this->setCreated(new \DateTime());
        }
        $this->setUpdated(new \DateTime());
    }

}

