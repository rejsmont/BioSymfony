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
 * VIB\Bundle\BioBundle\Entity\DNA\MiscFeature\MiscLocation
 *
 * @ORM\Table(name="DNAmiscLocation")
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\MiscFeature\MiscLocationRepository")
 */
class MiscLocation extends Abstracts\Location
{
    /**
     * @var MiscFeature $feature
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
