<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\GeneRelated
 */
interface GeneRelated {
    
    /**
     * Get gene
     * 
     * @return Collection 
     */
    public function getGene();
    
    /**
     * Get genes
     * 
     * @return Collection 
     */
    public function getGenes();
  
}

?>
