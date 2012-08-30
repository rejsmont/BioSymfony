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

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Abstracts\mRNAChild;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\UTR5
 * 
 * @ORM\Entity
 */
class UTR5 extends mRNAChild {
    
    /**
     * @var Collection $mRNAs
     * 
     * @ORM\ManyToMany(targetEntity="mRNA", mappedBy="UTR5s")
     */
    protected $mRNAs;
    
    
    
    /**
     * Add mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function addmRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs[] = $mRNA;
        if ($recurse === true) {
            $mRNA->addUTR5($this, false);
        }
    }
        
    /**
     * Remove mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function removemRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs->removeElement($mRNA);
        if ($recurse === true) {
            $mRNA->removeUTR5($mRNA, false);
        }
    }
    
}

?>