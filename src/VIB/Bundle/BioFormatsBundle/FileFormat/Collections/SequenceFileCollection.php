<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Collections;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;

use VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile;
use VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\SequenceFileIterator;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Collections\SequenceFileCollection
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SequenceFileCollection implements Collection, Selectable {
    
    /**
     *
     * @var VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile $sequenceFile
     */
    private $sequenceFile;
    
    
    
    /**
     * 
     * @param VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile $sequenceFile
     * @param Doctrine\Common\Collections\Collection $sequences;
     */
    public function __construct(SequenceFile $sequenceFile = null, $sequences = null) {
        $this->sequenceFile = $sequenceFile;
        if ($sequences instanceof Collection) {
            foreach ($sequences as $sequence) {
                $this->add($sequence);
            }
        }
    }
    
    /**
     * Adds an element to the collection.
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     * @return boolean 
     */
    public function add(AbstractSequence $sequence) {
        return true;
    }

    public function clear() {
        
    }

    public function contains(AbstractSequence $sequence) {
        
    }

    public function containsKey($key) {
        
    }

    /**
     * Returns the number of sequences in the collection.
     *
     * Implementation of the Countable interface.
     *
     * @return integer The number of sequences in the collection.
     */
    public function count() {
        return count($this->sequenceFile->getSequenceIndex());
    }

    public function current() {
        
    }

    public function exists(Closure $p) {
        
    }

    public function filter(Closure $p) {
        
    }

    public function first() {
        
    }

    public function forAll(Closure $p) {
        
    }

    /**
     * Gets the sequence at the specified key/index.
     * 
     * @param string $key The index of the element to retrieve.
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence The element or NULL, if no element exists for the given key.
     */
    public function get($key) {
        return $this->sequenceFile->readSequence($key);
    }

    public function getIterator() {
        return new SequenceFileIterator($this->sequenceFile);
    }

    /**
     * Gets all keys/indexes of the collection elements.
     *
     * @return array
     */
    public function getKeys() {
        return array_keys($this->sequenceFile->getSequenceIndex());
    }

    public function getValues() {
        
    }

    public function indexOf(AbstractSequence $sequence) {
        
    }

    public function isEmpty() {
        return ! $this->sequenceFile->getSequenceIndex();
    }

    public function key() {
        
    }

    public function last() {
        
    }

    public function map(Closure $func) {
        
    }

    public function matching(Criteria $criteria) {
        
    }

    public function next() {
        
    }

    public function offsetExists($offset) {
        
    }

    public function offsetGet($offset) {
        
    }

    public function offsetSet($offset, $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

    public function partition(Closure $p) {
        
    }

    public function remove($key) {
        
    }

    public function removeElement($element) {
        
    }

    public function set($key, $value) {
        
    }

    public function slice($offset, $length = null) {
        
    }

    public function toArray() {
        
    }
}

?>