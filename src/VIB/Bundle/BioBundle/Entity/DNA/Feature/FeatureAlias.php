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

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\FeatureAlias
 *
 * @ORM\Table(name="DNAfeatureAlias", indexes={
 *      @ORM\Index(name="alias_idx", columns={"alias"})
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\Feature\FeatureAliasRepository")
 */
class FeatureAlias extends Abstracts\FeatureAlias
{
    /**
     * @var Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
