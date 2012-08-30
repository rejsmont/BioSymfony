<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Sequence
 *
 * @ORM\Table(name="DNAsequence")
 * @ORM\Entity(repositoryClass="VIB\Bundle\BioBundle\Repository\DNA\SequenceRepository")
 */
class Sequence extends Abstracts\Sequence
{
    /**
     * @var Collection $features
     * 
     * @ORM\OneToMany(targetEntity="VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature", mappedBy="sequence")
     */
    protected $features;
    
}
