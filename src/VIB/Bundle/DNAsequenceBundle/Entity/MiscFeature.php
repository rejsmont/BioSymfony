<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\MiscFeature
 *
 * @ORM\Table(name="DNAmiscFeature", indexes={
 *      @ORM\Index(name="name_idx", columns={"name"}),
 *      @ORM\Index(name="type_idx", columns={"type"}),
 *      @ORM\Index(name="name_type_idx", columns={"name","type"}),
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\MiscFeatureRepository")
 */
class MiscFeature extends AbstractEntity\Feature
{
    /**
     * @var Collection $parents
     * 
     * @ORM\ManyToMany(targetEntity="MiscFeature", mappedBy="children")
     */
    protected $parents;

    /**
     * @var Collection $children
     * 
     * @ORM\ManyToMany(targetEntity="MiscFeature", inversedBy="parents")
     * @ORM\JoinTable(name="DNAmiscFeatureChildren",
     *      joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")}
     *      )
     */
    protected $children;
    
    /**
     * @var MiscFeature $origin
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature")
     * @ORM\JoinColumn(name="origin_id", referencedColumnName="id")
     */
    protected $origin;

    /**
     * @var Collection $aliases
     * 
     * @ORM\OneToMany(targetEntity="MiscFeatureAlias", mappedBy="feature")
     */
    protected $aliases;
    
    /**
     * @var Collection $locations
     * 
     * @ORM\OneToMany(targetEntity="MiscLocation", mappedBy="feature")
     */
    protected $locations;
    
    /**
     * @var Collection $tags
     * 
     * @ORM\OneToMany(targetEntity="MiscFeatureTag", mappedBy="feature")
     */
    protected $tags;

    /**
     * @var Sequence $sequence
     * 
     * @ORM\ManyToOne(targetEntity="Sequence", inversedBy="features")
     * @ORM\JoinColumn(name="sequence_id", referencedColumnName="id")
     */
    protected $sequence;
}
