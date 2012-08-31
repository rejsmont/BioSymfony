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
 * VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature
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
     * @var Doctrine\Common\Collections\Collection $parents
     */
    protected $parents;

    /**
     * @var Doctrine\Common\Collections\Collection $children
     */
    protected $children;
    
    /**
     * @var VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $origin
     */
    protected $origin;

    /**
     * @var Doctrine\Common\Collections\Collection $aliases
     */
    protected $aliases;
    
    /**
     * @var Doctrine\Common\Collections\Collection $locations
     */
    protected $locations;
    
    /**
     * @var Doctrine\Common\Collections\Collection $tags
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
     * @return Doctrine\Common\Collections\Collection  
     */
    public function getParents() {
        return $this->parents;
    }
    
    /**
     * Add parent
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $parent 
     * @param boolean $recurse 
     */
    public function addParent(Feature $parent,$recurse = true) {
        $this->parents[] = $parent;
        if ($recurse === true) {
            $parent->addChild($this, false);
        }
    }
        
    /**
     * Remove parent
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $parent 
     * @param boolean $recurse 
     */
    public function removeParent(Feature $parent,$recurse = true) {
        $this->parents->removeElement($parent);
        if ($recurse === true) {
            $parent->removeChild($this, false);
        }
    }
    
    /**
     * Get children
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren() {
        return $this->children;
    }
    
    /**
     * Add child
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $child 
     * @param boolean $recurse 
     */
    public function addChild(Feature $child,$recurse = true) {
        $this->children[] = $child;
        if ($recurse === true) {
            $child->addParent($this, false);
        }
    }
        
    /**
     * Remove child
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $child 
     * @param boolean $recurse 
     */
    public function removeChild(Feature $child,$recurse = true) {
        $this->parents->removeElement($child);
        if ($recurse === true) {
            $child->removeParent($this, false);
        }
    }

    /**
     * Get origin
     * 
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature 
     */
    public function getOrigin() {
        return $this->origin;
    }
    
    /**
     * Set origin
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $origin 
     */
    public function setOrigin(Feature $origin) {
        $this->origin = $origin;
    }

    /**
     * Get aliases
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAliases() {
        return $this->aliases;
    }

    /**
     * Add alias
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureAlias $alias 
     * @param boolean $recurse 
     */
    public function addAlias(FeatureAlias $alias,$recurse = true) {
        $this->aliases[] = $alias;
        if ($recurse === true) {
            $alias->setFeature($this,false);
        }
    }
        
    /**
     * Remove alias
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureAlias $alias 
     * @param boolean $recurse 
     */
    public function removeAlias(FeatureAlias $alias,$recurse = true) {
        $this->aliases->removeElement($alias);
        if ($recurse === true) {
            $alias->setFeature(null,false);
        }
    }

    /**
     * Get locations
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLocations() {
        return $this->locations;
    }

    /**
     * Add location
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Location $location 
     * @param boolean $recurse 
     */
    public function addLocation(Location $location,$recurse = true) {
        $this->locations[] = $location;
        if ($recurse === true) {
            $alias->setFeature($this,false);
        }
    }
        
    /**
     * Remove location
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Location $location 
     * @param boolean $recurse 
     */
    public function removeLocation(Location $location,$recurse = true) {
        $this->locations->removeElement($location);
        if ($recurse === true) {
            $location->setFeature(null,false);
        }
    }
    
    /**
     * Get tags
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Add tag
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureTag $tag 
     * @param boolean $recurse 
     */
    public function addTag(FeatureTag $tag,$recurse = true) {
        $this->tags[] = $tag;
        if ($recurse === true) {
            $tag->setFeature($this,false);
        }
    }
        
    /**
     * Remove tag
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureTag $tag 
     * @param boolean $recurse 
     */
    public function removeTag(FeatureTag $tag,$recurse = true) {
        $this->tags->removeElement($tag);
        if ($recurse === true) {
            $tag->setFeature(null,false);
        }
    }

    /**
     * Get sequence
     * 
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence 
     */
    public function getSequence() {
        return $this->sequence;
    }

    /**
     * Set sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     * @param boolean $recurse 
     */
    public function setSequence(Sequence $sequence,$recurse = true) {
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
