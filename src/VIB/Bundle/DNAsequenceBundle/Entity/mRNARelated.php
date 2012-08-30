<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\mRNARelated
 */
interface mRNARelated {
    
    /**
     * Get mRNA
     * 
     * @return mRNA
     * @return null
     * @return false if CDS is associated with multiple mRNAs
     */
    public function getmRNA();
    
    /**
     * Get mRNAs
     * 
     * @return Collection 
     */
    public function getmRNAs();
    
}

?>
