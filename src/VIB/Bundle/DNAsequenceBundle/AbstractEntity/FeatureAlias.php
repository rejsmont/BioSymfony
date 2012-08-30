<?php

namespace VIB\Bundle\DNAsequenceBundle\AbstractEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\AbstractEntity\FeatureAlias
 *
 * @ORM\MappedSuperclass
 */
abstract class FeatureAlias
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
     * @var string $alias
     * 
     * @ORM\Column(name="alias", type="string", length=255)
     */
    protected $alias;
    
    /**
     * @var Feature $feature
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
     * Get alias
     * 
     * @return string 
     */
    public function getAlias() {
        return $this->alias;
    }
    
    /**
     * Set alias
     * 
     * @param string $name 
     */
    public function setAlias($alias) {
        $this->alias = $alias;
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
    public function setFeature(Feature $feature,$recurse = true) {
        if ($recurse === true) {
            if ($feature != null) {
                $feature->addAlias($this,false);
            } elseif ($this->feature != null) {
                $this->feature->removeAlias($this,false);
            }
        }
        $this->feature = $feature;
    }
}
