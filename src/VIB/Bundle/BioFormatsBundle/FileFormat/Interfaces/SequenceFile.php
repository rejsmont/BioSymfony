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

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence as AbstractSequence;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile
 * 
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
interface SequenceFile {
    
    /**
     * Get sequence index
     * 
     * @return array
     */
    public function getSequenceIndex();
    
    /**
     * Get sequences
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSequences();
    
    /**
     * Add sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function addSequence(AbstractSequence $sequence);
    
    /**
     * Remove sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function removeSequence(AbstractSequence $sequence);
    
    /**
     * Replace sequence with the specified index using provided sequence
     * 
     * @param string $index 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function replaceSequence($indexEntry, AbstractSequence $sequence);
    
    /**
     * Remove sequence with the specified index
     * 
     * @param string $index 
     */
    public function deleteSequence($indexEntry);
    
    /**
     * Read single sequence from file
     * 
     * @param integer $indexEntry
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence|boolean The sequence read or false on error
     */
    public function readSequence($indexEntry = false);
}

?>
