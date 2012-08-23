<?php

namespace VIB\Bundle\DNAsequenceBundle\AbstractEntity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * VIB\Bundle\DNAsequenceBundle\AbstractEntity\Feature
 *
 * @ORM\MappedSuperclass
 */
abstract class Feature
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
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string $type
     * 
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;

    /**
     * @var Collection $parents
     */
    protected $parents;

    /**
     * @var Collection $children
     */
    protected $children;
    
    /**
     * @var Feature $origin
     */
    protected $origin;

    /**
     * @var Collection $aliases
     */
    protected $aliases;
    
    /**
     * @var Collection $locations
     */
    protected $locations;
    
    /**
     * @var Collection $tags
     */
    protected $tags;

    /**
     * @var Sequence $sequence
     */
    protected $sequence;
    
    
    
    public function __construct() {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->aliases = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->tags = new ArrayCollection();
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
     * Get type
     * 
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set type
     * 
     * @param string $type 
     */
    public function setType($type) {
        $this->type = $type;
    }
    
    /**
     * Get parents
     * 
     * @return Collection  
     */
    public function getParents() {
        return $this->parents;
    }
    
    /**
     * Add parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function addParent($parent,$recurse = true) {
        $this->parents[] = $parent;
        if ($recurse === true) {
            $parent->addChild($this, false);
        }
    }
        
    /**
     * Remove parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function removeParent($parent,$recurse = true) {
        $this->parents->removeElement($parent);
        if ($recurse === true) {
            $parent->removeChild($this, false);
        }
    }
    
    /**
     * Get children
     * 
     * @return Collection 
     */
    public function getChildren() {
        return $this->children;
    }
    
    /**
     * Add child
     * 
     * @param Feature $child 
     * @param boolean $recurse 
     */
    public function addChild($child,$recurse = true) {
        $this->children[] = $child;
        if ($recurse === true) {
            $child->addParent($this, false);
        }
    }
        
    /**
     * Remove child
     * 
     * @param Feature $child 
     * @param boolean $recurse 
     */
    public function removeChild($child,$recurse = true) {
        $this->parents->removeElement($child);
        if ($recurse === true) {
            $child->removeParent($this, false);
        }
    }

    /**
     * Get origin
     * 
     * @return Feature 
     */
    public function getOrigin() {
        return $this->origin;
    }
    
    /**
     * Set origin
     * 
     * @param Feature $origin 
     */
    public function setOrigin($origin) {
        $this->origin = $origin;
    }

    /**
     * Get aliases
     * 
     * @return Collection 
     */
    public function getAliases() {
        return $this->aliases;
    }

    /**
     * Add alias
     * 
     * @param FeatureAlias $alias 
     * @param boolean $recurse 
     */
    public function addAlias($alias,$recurse = true) {
        $this->aliases[] = $alias;
        if ($recurse === true) {
            $alias->setFeature($this,false);
        }
    }
        
    /**
     * Remove alias
     * 
     * @param FeatureAlias $alias 
     * @param boolean $recurse 
     */
    public function removeAlias($alias,$recurse = true) {
        $this->aliases->removeElement($alias);
        if ($recurse === true) {
            $alias->setFeature(null,false);
        }
    }

    /**
     * Get locations
     * 
     * @return Collection 
     */
    public function getLocations() {
        return $this->locations;
    }

    /**
     * Add location
     * 
     * @param Location $location 
     * @param boolean $recurse 
     */
    public function addLocation($location,$recurse = true) {
        $this->locations[] = $location;
        if ($recurse === true) {
            $alias->setFeature($this,false);
        }
    }
        
    /**
     * Remove location
     * 
     * @param Location $location 
     * @param boolean $recurse 
     */
    public function removeLocation($location,$recurse = true) {
        $this->locations->removeElement($location);
        if ($recurse === true) {
            $location->setFeature(null,false);
        }
    }
    
    /**
     * Get tags
     * 
     * @return Collection 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Add tag
     * 
     * @param FeatureTag $tag 
     * @param boolean $recurse 
     */
    public function addTag($tag,$recurse = true) {
        $this->tags[] = $tag;
        if ($recurse === true) {
            $tag->setFeature($this,false);
        }
    }
        
    /**
     * Remove tag
     * 
     * @param FeatureTag $tag 
     * @param boolean $recurse 
     */
    public function removeTag($tag,$recurse = true) {
        $this->tags->removeElement($tag);
        if ($recurse === true) {
            $tag->setFeature(null,false);
        }
    }

    /**
     * Get sequence
     * 
     * @return Sequence 
     */
    public function getSequence() {
        return $this->sequence;
    }

    /**
     * Set sequence
     * 
     * @param Sequence $sequence 
     * @param boolean $recurse 
     */
    public function setSequence($sequence,$recurse = true) {
        if ($recurse === true) {
            if ($sequence != null) {
                $sequence->addFeature($this,false);
            } elseif ($this->sequence != null) {
                $this->sequence->removeFeature($this,false);
            }
        }
        $this->sequence = $sequence;
    }
}
