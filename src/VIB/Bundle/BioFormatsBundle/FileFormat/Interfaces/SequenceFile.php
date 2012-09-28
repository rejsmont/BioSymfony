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
     * Get sequences
     * 
     * @api
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSequences();
    
    /**
     * Add sequence
     * 
     * @api
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function addSequence(AbstractSequence $sequence);
    
    /**
     * Remove sequence
     * 
     * @api
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function removeSequence(AbstractSequence $sequence);
    
    /**
     * Update sequence
     * 
     * @api
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     */
    public function updateSequence(AbstractSequence $sequence);
    
    /**
     * Get index of sequences
     * This method should only be used internally by Collections and Iterators
     * 
     * @return array
     */
    public function getSequenceIndex();
    
    /**
     * Read single sequence from file
     * This method should only be used internally by Collections and Iterators
     * 
     * @param integer $indexEntry
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence|boolean The sequence read or false on error
     */
    public function readSequence($indexEntry = false);
    
    /**
     * Replace the sequence indicated by indexEntry in the file with the new sequence
     * If the indexEntry is null, append the new sequence to the file
     * This method should only be used internally by Collections and Iterators
     * 
     * @param mixed $indexEntry
     * @param \VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     * @return mixed|boolean Index of the written sequence or FALSE on error
     */
    public function putSequence($indexEntry, AbstractSequence $sequence);
    
    /**
     * Remove the sequence indicated by indexEntry from the file
     * This method should only be used internally by Collections and Iterators
     * 
     * @param mixed $indexEntry
     */
    public function deleteSequence($indexEntry);
}

?>
