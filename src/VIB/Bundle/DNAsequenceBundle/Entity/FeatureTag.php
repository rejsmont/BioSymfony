<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\FeatureTag
 *
 * @ORM\Table(name="DNAfeatureTag", indexes={
 *      @ORM\Index(name="field_idx", columns={"field"}),
 *      @ORM\Index(name="value_idx", columns={"value"}),
 *      @ORM\Index(name="field_value_idx", columns={"field","value"})
 * })
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Entity\FeatureTagRepository")
 */
class FeatureTag
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
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="tags")
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
    public function setFeature($feature,$recurse = true) {
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
