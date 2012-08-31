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
 * VIB\Bundle\BioBundle\Entity\DNA\MiscFeature\MiscFeatureAlias
 *
 * @ORM\Table(name="DNAmiscFeatureAlias", indexes={
 *      @ORM\Index(name="alias_idx", columns={"alias"})
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\MiscFeature\MiscFeatureAliasRepository")
 */
class MiscFeatureAlias extends Abstracts\FeatureAlias
{
    /**
     * @var VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
