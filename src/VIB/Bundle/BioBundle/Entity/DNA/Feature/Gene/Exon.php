<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Abstracts\GeneChild;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Exon
 * 
 * @ORM\Entity
 */
class Exon extends GeneChild {
    
    /**
     * @var Collection $genes
     * 
     * @ORM\ManyToMany(targetEntity="Gene", mappedBy="exons")
     */
    protected $genes;

    
    
    /**
     * Add gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function addGene(Gene $gene,$recurse = true) {
        $this->genes[] = $gene;
        if ($recurse === true) {
            $gene->addExon($this, false);
        }
    }
        
    /**
     * Remove gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function removeGene(Gene $gene,$recurse = true) {
        $this->genes->removeElement($gene);
        if ($recurse === true) {
            $gene->removeExon($this, false);
        }
    }
    
}

?>