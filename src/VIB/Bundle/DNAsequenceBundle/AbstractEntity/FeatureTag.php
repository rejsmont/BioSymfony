<?php

namespace VIB\Bundle\DNAsequenceBundle\AbstractEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\AbstractEntity\FeatureTag
 *
 * @ORM\MappedSuperclass
 */
abstract class FeatureTag
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
     * @var string $field
     * 
     * @ORM\Column(name="field", type="string", length=255)
     */
    protected $field;
    
    /**
     * @var string $value
     * 
     * @ORM\Column(name="value", type="string", length=255)
     */
    protected $value;
    
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
     * Get field
     *
     * @return string 
     */
    public function getField() {
        return $this->field;
    }
    
    /**
     * Set field
     * 
     * @param string $field
     */
    public function setField($field) {
        $this->field = $field;
    }
    
    /**
     * Get value
     *
     * @return string 
     */
    public function getValue() {
        return $this->value;
    }
    
    /**
     * Set value
     * 
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
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
                $feature->addTag($this,false);
            } elseif ($this->feature != null) {
                $this->feature->removeTag($this,false);
            }
        }
        $this->feature = $feature;
    }


}
