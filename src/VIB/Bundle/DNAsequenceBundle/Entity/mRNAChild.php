<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\mRNAChild
 */
interface mRNAChild extends mRNARelated, GeneRelated {

    /**
     * Set mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function setmRNA(mRNA $mRNA,$recurse = true);
    
    /**
     * Add mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function addmRNA(mRNA $mRNA,$recurse = true);
    
    /**
     * Remove gene
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function removemRNA(mRNA $mRNA,$recurse = true);   
}

?>
