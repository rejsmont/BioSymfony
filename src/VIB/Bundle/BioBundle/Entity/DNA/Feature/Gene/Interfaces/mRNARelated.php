<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Interfaces;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Interfaces\mRNARelated
 * 
 */
interface mRNARelated {
    
    /**
     * Get mRNA
     * 
     * @return VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA
     * @return false if Feature is related to more than one mRNA 
     */
    public function getmRNA();
    
    /**
     * Get mRNAs
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getmRNAs();
    
}

?>
