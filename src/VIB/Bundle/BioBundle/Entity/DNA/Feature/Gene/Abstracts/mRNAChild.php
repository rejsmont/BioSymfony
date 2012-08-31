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
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Interfaces\mRNARelated;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Interfaces\GeneRelated;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Abstracts\mRNAChild
 * 
 */
abstract class mRNAChild extends Feature implements mRNARelated, GeneRelated {
    
    /**
     * @var Doctrine\Common\Collections\Collection $mRNAs
     * 
     */
    protected $mRNAs;
    
    
    
    public function __construct() {
        $this->mRNAs = new ArrayCollection();
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getmRNA() {
        $mRNAs = $this->getmRNAs();
        if ($mRNAs->count() == 1) {
            return $mRNAs->first();
        } else if ($mRNAs->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Set mRNA
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function setmRNA(mRNA $mRNA,$recurse = true) {
        $mRNAs = $this->getmRNAs();
        if ($mRNAs->count() > 0) {
            foreach ($mRNAs as $remmRNA) {
                $this->removemRNA($remmRNA,$recurse);
            }
        }
        if ($mRNA != null) {
            $this->addmRNA($mRNA,$recurse);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getmRNAs() {
        return $this->mRNAs;
    }
    
    /**
     * Add mRNA
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA $mRNA 
     * @param boolean $recurse 
     */
    abstract public function addmRNA(mRNA $mRNA,$recurse = true);
        
    /**
     * Remove mRNA
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA $mRNA 
     * @param boolean $recurse 
     */
    abstract public function removemRNA(mRNA $mRNA,$recurse = true);
    
    /**
     * {@inheritDoc}
     */
    public function getGene() {
        $genes = $this->getGenes();
        if ($genes->count() == 1) {
            return $genes->first();
        } else if ($genes->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getGenes() {
        $genes = new ArrayCollection();
        foreach ($this->getmRNAs() as $mRNA) {
            foreach ($mRNA->getGenes() as $gene) {
                if ((!$genes->contains($gene))&&((!$mRNA->isPolycistronic())||($this->getOrigin() == $gene))) {
                    $genes->add($gene);
                }
            }
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getParents() {
        $parents = parent::getParents();
        foreach ($this->getmRNAs() as $mRNA) {
            if (!$parents->contains($mRNA)) {
                $parents->add($mRNA);
            }
        }
        return $parents;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addParent(Abstracts\Feature $parent,$recurse = true) {
        if ($parent instanceof mRNA) {
            $this->addmRNA($parent,$recurse);
        } else {
            parent::addParent($parent, $recurse);
        }
    }
        
    /**
     * {@inheritDoc}
     */
    public function removeParent(Abstracts\Feature $parent,$recurse = true) {
        if ($parent instanceof mRNA) {
            $this->removemRNA($parent,$recurse);
        } else {
            parent::removeParent($parent, $recurse);
        }
    }
  
}

?>
