<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\GeneChild
 */
interface GeneChild extends GeneRelated {
    
    /**
     * Set gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function setGene(Gene $gene,$recurse = true);
    
    /**
     * Add gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function addGene(Gene $gene,$recurse = true);
    
    /**
     * Remove gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function removeGene(Gene $gene,$recurse = true);
  
}

?>
