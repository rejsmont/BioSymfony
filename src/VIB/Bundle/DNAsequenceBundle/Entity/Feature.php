<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Feature
 *
 * @ORM\Table(name="DNAfeature", indexes={
 *      @ORM\Index(name="name_idx", columns={"name"}),
 *      @ORM\Index(name="type_idx", columns={"type"}),
 *      @ORM\Index(name="name_type_idx", columns={"name","type"})
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Entity\FeatureRepository")
 */
class Feature
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
     * 
     * @ORM\ManyToMany(targetEntity="Feature", mappedBy="children")
     */
    protected $parents;

    /**
     * @var Collection $children
     * 
     * @ORM\ManyToMany(targetEntity="Feature", inversedBy="parents")
     * @ORM\JoinTable(name="DNAfeature_parents_children",
     *      joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     */
    protected $children;
    
    /**
     * @var Feature $origin
     * 
     * @ORM\ManyToOne(targetEntity="Feature")
     * @ORM\JoinColumn(name="origin_id", referencedColumnName="id")
     */
    protected $origin;

    /**
     * @var Collection $aliases
     * 
     * @ORM\OneToMany(targetEntity="FeatureAlias", mappedBy="feature")
     */
    protected $aliases;
    
    /**
     * @var Collection $locations
     * 
     * @ORM\OneToMany(targetEntity="Location", mappedBy="feature")
     */
    protected $locations;
    
    /**
     * @var Collection $tags
     * 
     * @ORM\OneToMany(targetEntity="FeatureTag", mappedBy="feature")
     */
    protected $tags;

    /**
     * @var Sequence $sequence
     * 
     * @ORM\ManyToOne(targetEntity="Sequence", inversedBy="features")
     * @ORM\JoinColumn(name="sequence_id", referencedColumnName="id")
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
     */
    public function addParent($parent) {
        $this->parents[] = $parent;
    }
        
    /**
     * Remove parent
     * 
     * @param Feature $parent 
     */
    public function removeParent($parent) {
        $this->parents->removeElement($parent);
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
     */
    public function addChild($child) {
        $this->children[] = $child;
    }
        
    /**
     * Remove child
     * 
     * @param Feature $child 
     */
    public function removeChild($child) {
        $this->parents->removeElement($child);
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
     */
    public function addAlias($alias) {
        $this->aliases[] = $alias;
    }
        
    /**
     * Remove alias
     * 
     * @param FeatureAlias $alias 
     */
    public function removeAlias($alias) {
        $this->aliases->removeElement($alias);
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
     */
    public function addLocation($location) {
        $this->locations[] = $location;
    }
        
    /**
     * Remove location
     * 
     * @param Location $location 
     */
    public function removeLocation($location) {
        $this->locations->removeElement($location);
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
     */
    public function addTag($tag) {
        $this->tags[] = $tag;
    }
        
    /**
     * Remove tag
     * 
     * @param FeatureTag $tag 
     */
    public function removeTag($tag) {
        $this->tags->removeElement($tag);
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
     */
    public function setSequence($sequence) {
        $this->sequence = $sequence;
    }


}
