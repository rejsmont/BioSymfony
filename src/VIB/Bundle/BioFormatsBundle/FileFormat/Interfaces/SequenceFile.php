<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile
 * 
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
interface SequenceFile {
    
    /**
     * Get sequences
     * 
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSequences();
    
    /**
     * Add sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Sequence $sequence 
     */
    public function addSequence(AbstractSequence $sequence);
    
    /**
     * Remove sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Sequence $sequence 
     */
    public function removeSequence(AbstractSequence $sequence);
    
}

?>
