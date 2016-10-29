<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
{


    public function __construct( $name, $description = "")
    {
        $this->name = $name;
        $this->description = $description;
        $this->score = 0;
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
    * @ORM\ManyToMany(targetEntity="PointHistory", mappedBy="people")
    */
    private $pointHistory;
    

    /**
    * @ORM\ManyToOne(targetEntity="SlackDomain", inversedBy="people")
    */
    private $domain;


    /**
     * @ORM\OneToMany(targetEntity="PointHistory", mappedBy="submitter")
     */
    private $mySubmissions;



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
     * Set name
     *
     * @param string $name
     *
     * @return Person
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
     * Set score
     *
     * @param string $scorename
     *
     * @return Person
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

        
    /**
     * Set score
     *
     * @param string $scorename
     *
     * @return Person
     */
    public function addScore($score)
    {
        $this->score += $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
    public function setPointHistory($ph)
    {   
        $this->pointHistory[] = $ph;
        if($ph->getReferencedPeople() === null || !in_array($this,$ph->getReferencedPeople())){
            $ph->setReferencedPeople($this);
        }
        return;
    }

    /**
     * Get pointHistory
     * @return array PointHistory
     */
    public function getDomain()
    {
        return $this->domain;
    }


    /**
     * Get pointHistory
     * @return array PointHistory
     */
    public function getMySubmissions()
    {
        return $this->mySubmissions;
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

}

