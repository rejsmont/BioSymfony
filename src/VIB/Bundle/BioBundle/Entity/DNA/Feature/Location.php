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
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Location
 *
 * @ORM\Table(name="DNAlocation", indexes={
 *      @ORM\Index(name="start_idx", columns={"start"}),
 *      @ORM\Index(name="end_idx", columns={"end"}),
 *      @ORM\Index(name="strand_idx", columns={"strand"}),
 *      @ORM\Index(name="start_end_idx", columns={"start","end"}),
 *      @ORM\Index(name="start_end_strand_idx", columns={"start","end","strand"}),
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\Feature\LocationRepository")
 */
class Location extends Abstracts\Location
{
    /**
     * @var VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
