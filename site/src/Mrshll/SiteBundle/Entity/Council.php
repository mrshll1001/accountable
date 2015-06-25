<?php

namespace Mrshll\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Council
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Council
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="council")
     */
     protected $records;

     public function __construct()
     {
       $this->records = new ArrayCollection();
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
     * @return Council
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
     * Add records
     *
     * @param \Mrshll\SiteBundle\Entity\Record $records
     * @return Council
     */
    public function addRecord(\Mrshll\SiteBundle\Entity\Record $records)
    {
        $this->records[] = $records;

        return $this;
    }

    /**
     * Remove records
     *
     * @param \Mrshll\SiteBundle\Entity\Record $records
     */
    public function removeRecord(\Mrshll\SiteBundle\Entity\Record $records)
    {
        $this->records->removeElement($records);
    }

    /**
     * Get records
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }
}
