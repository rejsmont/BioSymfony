<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Feature
 *
 * @ORM\Table(name="DNAfeature", indexes={
 *      @ORM\Index(name="class_idx", columns={"class"}),
 *      @ORM\Index(name="name_idx", columns={"class","name"}),
 *      @ORM\Index(name="type_idx", columns={"class","type"}),
 *      @ORM\Index(name="name_type_idx", columns={"class","name","type"}),
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\FeatureRepository")
 * 
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="class", type="string")
 * @ORM\DiscriminatorMap({
 *      "feature" = "Feature",
 *      "gene" = "Gene",
 *      "mrna" = "mRNA",
 * })
 */
class Feature extends AbstractEntity\Feature
{   
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
     * @ORM\JoinTable(name="DNAfeatureChildren",
     *      joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")}
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
    
}
