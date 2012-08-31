<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Abstracts;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence
 *
 * @ORM\MappedSuperclass
 */
abstract class Sequence
{
    /**
     * @const sequenceType DNA
     *
     */
    const sequenceType = 'DNA';
  
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $version
     * 
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     */
    protected $version;
    
    /**
     * @var DateTime $date
     * 
     * @ORM\Column(name="date", type="date")
     */
    protected $date;
    
    /**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string $sequence
     * 
     * @ORM\Column(name="sequence", type="text")
     */
    protected $sequence;
    
    /**
     * @var boolean $circular
     * 
     * @ORM\Column(name="circular", type="boolean")
     */
    protected $circular;
    
    /**
     * @var Doctrine\Common\Collections\Collection $features
     */
    protected $features;

    
    
    public function __construct() {
      $this->features = new ArrayCollection();
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
     * Get version
     *
     * @return integer 
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Get date
     * 
     * @return DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set date
     * 
     * @param DateTime $date 
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * Get name
     * 
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set name
     * 
     * @param string $name 
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get sequence
     * 
     * @return string 
     */
    public function getSequence() {
        return $this->sequence;
    }

    /**
     * Set sequence
     * 
     * @param string $sequence
     */
    public function setSequence($sequence) {
        $this->sequence = $sequence;
    }

    /**
     * Is circular
     * 
     * @return boolean
     */
    public function isCircular() {
        return $this->circular;
    }

    /**
     * Set circular
     * 
     * @param boolean $circular
     */
    public function setCircular($circular) {
        $this->circular = $circular;
    }

    /**
     * Get features
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFeatures() {
        return $this->features;
    }

    /**
     * Add feature
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $feature
     * @param boolean $recurse 
     */
    public function addFeature(Feature $feature,$recurse = true) {
        $this->features[] = $feature;
        if ($recurse === true) {
            $feature->setSequence($this,false);
        }
    }
    
    /**
     * Remove feature
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $feature
     * @param boolean $recurse 
     */
    public function removeFeature(Feature $feature,$recurse = true) {
        $this->features->removeElement($feature);
        if ($recurse === true) {
            $feature->setSequence(null,false);
        }
    }
}
