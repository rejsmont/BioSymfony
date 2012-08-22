<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Location
 *
 * @ORM\Table(name="DNAlocation")
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Entity\LocationRepository")
 */
class Location
{
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
     * @var string $start
     * 
     * @ORM\Column(name="start", type="integer")
     */
    protected $start;
    
    /**
     * @var string $end
     * 
     * @ORM\Column(name="end", type="integer")
     */
    protected $end;
    
    /**
     * @var string $strand
     * 
     * @ORM\Column(name="strand", type="string", length=1)
     */
    protected $strand;

    /**
     * @var Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
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
     * Get start
     * 
     * @return integer 
     */
    public function getStart() {
        return $this->start;
    }
    
    /**
     * Set start
     * 
     * @param integer $start 
     */
    public function setStart($start) {
        $this->start = $start;
    }
    
    /**
     * Get end
     * 
     * @return integer 
     */
    public function getEnd() {
        return $this->end;
    }
    
    /**
     * Set end
     * 
     * @param integer $end 
     */
    public function setEnd($end) {
        $this->end = $end;
    }
    
    /**
     * Get strand
     * 
     * @return string 
     */
    public function getStrand() {
        return $this->strand;
    }
    
    /**
     * Set strand
     * 
     * @param string $strand 
     */
    public function setStrand($strand) {
        $this->strand = $strand;
    }
        
    /**
     * Get feature
     *
     * @return Feature 
     */
    public function getFeature() {
        return $this->feature;
    }

    /**
     * Set feature
     * 
     * @param Feature $feature 
     * @param boolean $recurse 
     */
    public function setFeature($feature,$recurse = true) {
        if ($recurse === true) {
            if ($feature != null) {
                $feature->addLocation($this,false);
            } elseif ($this->feature != null) {
                $this->feature->removeLocation($this,false);
            }
        }
        $this->feature = $feature;
    }
}
