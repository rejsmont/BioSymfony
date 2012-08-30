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
 * VIB\Bundle\BioBundle\Entity\DNA\MiscFeature\MiscFeatureTag
 *
 * @ORM\Table(name="DNAmiscFeatureTag", indexes={
 *      @ORM\Index(name="field_idx", columns={"field"}),
 *      @ORM\Index(name="value_idx", columns={"value"}),
 *      @ORM\Index(name="field_value_idx", columns={"field","value"})
 * })
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\MiscFeature\MiscFeatureTagRepository")
 */
class MiscFeatureTag extends Abstracts\FeatureTag
{
    /**
     * @var MiscFeature $feature
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature", inversedBy="tags")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
