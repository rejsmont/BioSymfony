<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Iterators;

use VIB\Bundle\BioFormatsBundle\FileFormat\Iterfaces\SequenceFile;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\SequenceFileIterator
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SequenceFileIterator extends Abstracts\IndexedFileIterator {
    
    /**
     *
     * @var VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile $sequenceFile
     */
    private $sequenceFile;
    
    
    
    /**
     * 
     * @param VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile $sequenceFile
     */
    public function __construct(SequenceFile $sequenceFile) {
        $this->sequenceFile = $sequenceFile;
        $this->iterator = new \ArrayIterator($this->sequenceFile->getSequenceIndex());
    }

    /**
     * Return the current sequence.
     *
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence The current sequence.
     */
    public function current() {
        return $this->sequenceFile->readSequence($this->iterator->key());
    }

    /**
     * Return the sequence at specified offset.
     * 
     * @param mixed $offset
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence 
     */
    public function offsetGet($offset) {
        return $this->sequenceFile->readSequence($offset);
    }

    /**
     * Assign sequence to the specified offset.
     * 
     * @param mixed $offset
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $value
     */
    public function offsetSet($offset, $value) {
        return $this->sequenceFile->replaceSequenceAtIndex($offset, $value);
    }

    /**
     * Unset an offset.
     * 
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        return $this->sequenceFile->removeSequenceAtIndex($offset);
    }
}

?>