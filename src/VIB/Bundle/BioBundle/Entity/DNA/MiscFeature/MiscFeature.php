<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\MiscFeature;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts as Abstracts;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\MiscFeature\MiscFeature
 *
 * @ORM\Table(name="DNAmiscFeature", indexes={
 *      @ORM\Index(name="name_idx", columns={"name"}),
 *      @ORM\Index(name="type_idx", columns={"type"}),
 *      @ORM\Index(name="name_type_idx", columns={"name","type"}),
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\MiscFeature\MiscFeatureRepository")
 */
class MiscFeature extends Abstracts\Feature
{
    /**
     * @var Doctrine\Common\Collections\Collection $parents
     * 
     * @ORM\ManyToMany(targetEntity="MiscFeature", mappedBy="children")
     */
    protected $parents;

    /**
     * @var Doctrine\Common\Collections\Collection $children
     * 
     * @ORM\ManyToMany(targetEntity="MiscFeature", inversedBy="parents")
     * @ORM\JoinTable(name="DNAmiscFeatureChildren",
     *      joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")}
     *      )
     */
    protected $children;
    
    /**
     * @var VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $origin
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature")
     * @ORM\JoinColumn(name="origin_id", referencedColumnName="id")
     */
    protected $origin;

    /**
     * @var Doctrine\Common\Collections\Collection $aliases
     * 
     * @ORM\OneToMany(targetEntity="MiscFeatureAlias", mappedBy="feature")
     */
    protected $aliases;
    
    /**
     * @var Doctrine\Common\Collections\Collection $locations
     * 
     * @ORM\OneToMany(targetEntity="MiscLocation", mappedBy="feature")
     */
    protected $locations;
    
    /**
     * @var Doctrine\Common\Collections\Collection $tags
     * 
     * @ORM\OneToMany(targetEntity="MiscFeatureTag", mappedBy="feature")
     */
    protected $tags;

    /**
     * @var VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     * 
     * @ORM\ManyToOne(targetEntity="VIB\Bundle\BioBundle\Entity\DNA\Sequence", inversedBy="features")
     * @ORM\JoinColumn(name="sequence_id", referencedColumnName="id")
     */
    protected $sequence;
}
