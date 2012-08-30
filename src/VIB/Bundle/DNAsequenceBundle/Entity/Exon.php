<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\mRNA
 * 
 * @ORM\Entity
 */
class Exon extends Feature implements GeneChild {
    
    /**
     * @var Collection $genes
     * 
     * @ORM\ManyToMany(targetEntity="Gene", mappedBy="exons")
     */
    protected $genes;

    
    
    public function __construct() {
        $this->genes = new ArrayCollection();
        parent::__construct();
    }
    
    /**
     * Get gene
     * 
     * @return Gene
     * @return false if mRNA is polycistronic 
     */
    public function getGene() {
        if ($this->genes->count() == 1) {
            return $this->genes->first();
        } else if ($this->genes->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Set gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function setGene(Gene $gene,$recurse = true) {
        if ($this->genes->count() > 0) {
            foreach ($this->genes as $remgene) {
                $this->removeGene($remgene,$recurse);
            }
        }
        $this->addGene($gene,$recurse);
    }
    
    /**
     * Get genes
     * 
     * @return Collection 
     */
    public function getGenes() {
        return $this->genes;
    }
    
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
    
    /**
     * Get parents
     * 
     * @return Collection  
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
     * Add parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function addParent(Feature $parent,$recurse = true) {
        if ($parent instanceof Gene) {
            $this->addGene($parent,$recurse);
        } else {
            parent::addParent($parent, $recurse);
        }
    }
        
    /**
     * Remove parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function removeParent(Feature $parent,$recurse = true) {
        if ($parent instanceof Gene) {
            $this->removeGene($parent,$recurse);
        } else {
            parent::removeParent($parent, $recurse);
        }
    }
    
}

?>