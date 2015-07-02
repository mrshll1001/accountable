<?php

namespace Mrshll\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CouncilRecord
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CouncilRecord
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
     * @ORM\Column(name="vendor", type="string", length=255)
     */
    private $vendor;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=100)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="councilcode", type="string", length=20)
     */
    private $councilcode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
     private $description;


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
     * Set vendor
     *
     * @param string $vendor
     * @return CouncilRecord
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return CouncilRecord
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set service
     *
     * @param string $service
     * @return CouncilRecord
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return CouncilRecord
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set councilcode
     *
     * @param string $councilcode
     * @return CouncilRecord
     */
    public function setCouncilcode($councilcode)
    {
        $this->councilcode = $councilcode;

        return $this;
    }

    /**
     * Get councilcode
     *
     * @return string
     */
    public function getCouncilcode()
    {
        return $this->councilcode;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CouncilRecord
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
}
