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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use VIB\Bundle\BioFormatsBundle\FileFormat\Interfaces\SequenceFile;
use VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\SequenceFileIterator;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Collections\SequenceFileCollection
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SequenceFileCollection implements Doctrine\Common\Collections\Collection {
    
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
     * Get the PHP array representation of this collection.
     *
     * @return array The PHP array representation of this collection.
     */
    public function toArray() {
        $sequences = array();
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequences[$indexEntry] = $this->sequenceFile->readSequence($indexEntry);
        }
        return $sequences;
    }

    /**
     * Check whether the collection is empty.
     * 
     * Note: This is preferrable over count() == 0.
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty() {
        return ! $this->sequenceFile->getSequenceIndex();
    }

    /**
     * Return the number of sequences in the collection.
     *
     * Implementation of the Countable interface.
     *
     * @return integer The number of sequences in the collection.
     */
    public function count() {
        return count($this->sequenceFile->getSequenceIndex());
    }
    
    /**
     * Get the sequence at the current internal iterator position.
     *
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence
     */
    public function current() {
        return $this->sequenceFile->readSequence(current($this->sequenceFile->getSequenceIndex()));
    }

    /**
     * Move the internal iterator position to the next sequence.
     *
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence 
     */
    public function next() {
        return $this->sequenceFile->readSequence(next($this->sequenceFile->getSequenceIndex()));
    }

    /**
     * Set the internal iterator to the first sequence in the collection and
     * return this sequence.
     *
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence
     */
    public function first() {
        return $this->sequenceFile->readSequence(reset($this->sequenceFile->getSequenceIndex()));
    }

    /**
     * Set the internal iterator to the last sequence in the collection and
     * return this sequence.
     *
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence 
     */
    public function last() {
        return $this->sequenceFile->readSequence(end($this->sequenceFile->getSequenceIndex()));
    }

    /**
     * Get the current key/index at the current internal iterator position.
     *
     * @return mixed
     */
    public function key() {
        return key($this->sequenceFile->getSequenceIndex());
    }

    /**
     * Get the sequence at the specified key/index.
     * 
     * @param string $key The index of the sequence to retrieve.
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence The sequence or NULL,
     *          if no sequence exists for the given key.
     */
    public function get($key) {
        return $this->sequenceFile->readSequence($key);
    }

    /**
     * Add an element to the collection.
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     * @return boolean 
     */
    public function add(AbstractSequence $sequence) {
        return $this->sequenceFile->replaceSequenceAtIndex(null, $sequence);
    }
    
    /**
     * Remove a sequence with a specific key/index from the collection.
     *
     * @param mixed $key
     * @return mixed The removed sequence or NULL, if no sequence exists for the given key.
     */
    public function remove($key) {
        $index = $this->sequenceFile->getSequenceIndex();
        if (isset($index[$key])) {
            $removed = $this->sequenceFile->readSequence($key);
            $this->sequenceFile->removeSequenceAtIndex($key);
            return $removed;
        }
        return null;
    }

    /**
     * Remove the specified sequence from the collection, if it is found.
     *
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence The sequence to remove.
     * @return boolean TRUE if this collection contained the specified sequence, FALSE otherwise.
     */
    public function removeElement(AbstractSequence $sequence) {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $read_sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($sequence == $read_sequence) {
                $this->sequenceFile->removeSequenceAtIndex($indexEntry);
                return true;
            }
        }
        return false;
    }

    /**
     * Adds/sets a sequence in the collection at the index / with the specified key.
     *
     * When the collection is a Map this is like put(key,value)/add(key,value).
     * When the collection is a List this is like add(position,value).
     *
     * @param mixed $key
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     */
    public function set($key, AbstractSequence $sequence) {
        return $this->sequenceFile->replaceSequenceAtIndex($key, $sequence);
    }

    /**
     * Get all keys/indexes of the sequences in the collection.
     *
     * @return array
     */
    public function getKeys() {
        return array_keys($this->sequenceFile->getSequenceIndex());
    }

    /**
     * Get all sequences.
     *
     * @return array
     */
    public function getValues() {
        $sequences = array();
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequences[] = $this->sequenceFile->readSequence($indexEntry);
        }
        return $sequences;
    }

    /**
     * Clear the collection.
     * 
     */
    public function clear() {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $this->sequenceFile->removeSequenceAtIndex($indexEntry);
        }
    }
    
    /**
     * Check whether the given sequence is contained in the collection.
     * Only values are compared, not keys.
     *
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     * @return boolean TRUE if the given element is contained in the collection,
     *          FALSE otherwise.
     */
    public function contains(AbstractSequence $sequence) {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $read_sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($sequence == $read_sequence) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check whether the collection contains a specific key/index.
     *
     * @param mixed $key The key to check for.
     * @return boolean TRUE if the given key/index exists, FALSE otherwise.
     */
    public function containsKey($key) {
        $index = $this->sequenceFile->getSequenceIndex();
        return isset($index[$key]);
    }

    /**
     * Search for a given sequence and, if found, return the corresponding key/index
     * of that sequence.
     *
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence The sequence to search for.
     * @return mixed The key/index of the sequence or FALSE if the sequence was not found.
     */
    public function indexOf(AbstractSequence $sequence) {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $read_sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($sequence == $read_sequence) {
                return $indexEntry;
            }
        }
        return false;
    }

    /**
     * Test for the existance of a sequence that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE if the predicate is TRUE for at least one sequence, FALSE otherwise.
     */
    public function exists(Closure $p) {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($p($indexEntry, $sequence)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return all the sequences of this collection that satisfy the predicate.
     * The order of the sequences is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     * @return Doctrine\Common\Collections\Collection A collection with the results of the filter operation.
     */
    public function filter(Closure $p) {
        $sequences = new ArrayCollection();
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($p($sequence)) {
                $sequences->add($sequence);
            }
        }
        return $sequences;
    }

    /**
     * Apply the given predicate to all sequences of this collection,
     * returning true, if the predicate yields true for all sequences.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE, if the predicate yields TRUE for all sequences, FALSE otherwise.
     */
    public function forAll(Closure $p) {
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequence = $this->sequenceFile->readSequence($indexEntry);
            if (! $p($indexEntry, $sequence)) {
                return false;
            }
            $this->sequenceFile->replaceSequenceAtIndex($indexEntry, $sequence);
        }
        return true;
    }

    /**
     * Apply the given function to each sequence in the collection and return
     * a new collection with the sequences returned by the function.
     *
     * @param Closure $func
     * @return Collection
     */
    public function map(Closure $func) {
        $sequences = new ArrayCollection();
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequence = $this->sequenceFile->readSequence($indexEntry);
            $sequences->set($indexEntry,$func($sequence));
        }
        return $sequences;
    }

    /**
     * Partition this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param Closure $p The predicate on which to partition.
     * @return array An array with two elements. The first element contains the collection
     *               of sequences where the predicate returned TRUE, the second element
     *               contains the collection of sequences where the predicate returned FALSE.
     */
    public function partition(Closure $p) {
        $coll_1 = new ArrayCollection();
        $coll_2 = new ArrayCollection();
        foreach ($this->sequenceFile->getSequenceIndex() as $indexEntry) {
            $sequence = $this->sequenceFile->readSequence($indexEntry);
            if ($p($indexEntry, $sequence)) {
                $coll_1->set($indexEntry,$sequence);
            } else {
                $coll_2->set($indexEntry,$sequence);
            }
        }
        return array($coll_1, $coll_2);
    }

    /**
     * Extract a slice of $length sequences starting at position $offset from the Collection.
     *
     * If $length is null it returns all sequences from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the sequences contained in the collection slice is called on.
     *
     * @param int $offset
     * @param int $length
     * @return array
     */
    public function slice($offset, $length = null) {
        $sequences = array();
        $index = array_slice($this->sequenceFile->getSequenceIndex(), $offset, $length, true);
        foreach ($index as $indexEntry) {
            $sequences[$indexEntry] = $this->sequenceFile->readSequence($indexEntry);
        }
        return $sequences;
    }
    
    /**
     * ArrayAccess implementation of offsetExists()
     *
     * @see containsKey()
     */
    public function offsetExists($offset) {
        return $this->containsKey($offset);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see get()
     */
    public function offsetGet($offset) {
        return $this->get($offset);
    }
    
    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see add()
     * @see set()
     */
    public function offsetSet($offset, $value) {
        if ( ! isset($offset)) {
            return $this->add($value);
        }
        return $this->set($offset, $value);
    }

    /**
     * ArrayAccess implementation of offsetUnset()
     *
     * @see remove()
     */
    public function offsetUnset($offset) {
        return $this->remove($offset);
    }

    /**
     * Get an iterator for iterating over the sequences in the collection.
     *
     * @return VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\SequenceFileIterator
     */
    public function getIterator() {
        return new SequenceFileIterator($this->sequenceFile);
    }
    
}

?>