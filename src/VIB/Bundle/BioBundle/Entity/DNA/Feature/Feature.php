<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Feature;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts as Abstracts;
use VIB\Bundle\BioBundle\Entity\DNA\Sequence;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature
 *
 * @ORM\Table(name="DNAfeature", indexes={
 *      @ORM\Index(name="class_idx", columns={"class"}),
 *      @ORM\Index(name="name_idx", columns={"class","name"}),
 *      @ORM\Index(name="type_idx", columns={"class","type"}),
 *      @ORM\Index(name="name_type_idx", columns={"class","name","type"}),
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\Feature\FeatureRepository")
 * 
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="class", type="string")
 * @ORM\DiscriminatorMap({
 *      "feature" = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature",
 *      "gene"    = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene",
 *      "exon"    = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Exon",
 *      "intron"  = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Intron",
 *      "mRNA"    = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA",
 *      "CDS"     = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\CDS",
 *      "UTR5"    = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\UTR5",
 *      "UTR3"    = "VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\UTR3",
 * })
 */
class Feature extends Abstracts\Feature
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
     * @ORM\ManyToOne(targetEntity="VIB\Bundle\BioBundle\Entity\DNA\Sequence", inversedBy="features")
     * @ORM\JoinColumn(name="sequence_id", referencedColumnName="id")
     */
    protected $sequence;
    
}
