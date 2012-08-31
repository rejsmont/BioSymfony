<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Abstracts;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts as Abstracts;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Interfaces\GeneRelated;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Abstracts\GeneChild
 * 
 */
abstract class GeneChild extends Feature implements GeneRelated {
    
    /**
     * @var Doctrine\Common\Collections\Collection $genes
     * 
     */
    protected $genes;
    
    
    
    public function __construct() {
        $this->genes = new ArrayCollection();
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getGene() {
        $genes = $this->getGenes();
        if ($genes->count() == 1) {
            return $genes->first();
        } elseif ($genes->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Set gene
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene $gene 
     * @param boolean $recurse 
     */
    public function setGene(Gene $gene,$recurse = true) {
        $genes = $this->getGenes();
        if ($genes->count() > 0) {
            foreach ($genes as $remgene) {
                $this->removeGene($remgene,$recurse);
            }
        }
        if ($gene != null) {
            $this->addGene($gene,$recurse);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getGenes() {
        return $this->genes;
    }
    
    /**
     * Add gene
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene $gene 
     * @param boolean $recurse 
     */
    abstract public function addGene(Gene $gene,$recurse = true);
    
    /**
     * Remove gene
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene $gene 
     * @param boolean $recurse 
     */
    abstract public function removeGene(Gene $gene,$recurse = true);
    
    /**
     * {@inheritDoc}
     */
    public function getParents() {
        $parents = parent::getParents();
        foreach ($this->genes as $gene) {
            if (!$parents->contains($gene)) {
                $parents->add($gene);
            }
        }
        return $parents;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addParent(Abstracts\Feature $parent,$recurse = true) {
        if ($parent instanceof Gene) {
            $this->addGene($parent,$recurse);
        } else {
            parent::addParent($parent, $recurse);
        }
    }
        
    /**
     * {@inheritDoc}
     */
    public function removeParent(Abstracts\Feature $parent,$recurse = true) {
        if ($parent instanceof Gene) {
            $this->removeGene($parent,$recurse);
        } else {
            parent::removeParent($parent, $recurse);
        }
    }
    
}

?>
