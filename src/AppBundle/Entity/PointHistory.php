<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointHistory
 *
 * @ORM\Table(name="point_history")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointHistoryRepository")
 */
class PointHistory
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
    * @ORM\ManyToMany(targetEntity="Person", inversedBy="pointHistory")
    * @ORM\JoinTable(name="people_history")
    */
    private $people;

    /**
    * @ORM\ManyToOne(targetEntity="SlackDomain", inversedBy="pointHistory")
    */
    private $domain;

    /**
    * @ORM\ManyToOne(targetEntity="Person", inversedBy="mySubmissions")
    */
    private $submitter;


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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PointHistory
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
     * Set domain
     *
     * @param string $domain
     *
     * @return SlackDomain
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }




    /**
     * Set score
     *
     * @param integer $score
     *
     * @return PointHistory
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
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
     * Set score
     *
     * @param integer $score
     *
     * @return PointHistory
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }


    /**
     * Set setSubmitter
     *
     * @param integer $submitter
     *
     * @return PointHistory
     */
    public function setSubmitter($submitter)
    {
        $this->submitter = $submitter;
    }

    /**
     * Get pointHistory
     * @return array PointHistory
     */
    public function setReferencedPeople($person)
    {      
        $this->people[] = $person;

        if($person->getPointHistory() === null || !$person->getPointHistory()->contains($this)){
            $person->setPointHistory($this);
        }
        return   $this;
    }

    public function getReferencedPeople()
    {      
        return   $this->people;
    }

    

    /**
    * @ORM\PrePersist
    */
    public function prePersist() {
        if( empty($this->created) ) {
            $this->setCreated(new \DateTime());
        }
    }
    
    
}

