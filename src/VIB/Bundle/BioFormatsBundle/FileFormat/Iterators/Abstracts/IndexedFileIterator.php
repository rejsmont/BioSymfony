<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\Abstracts;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Iterators\IndexedFileIterator
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
abstract class IndexedFileIterator implements \Iterator, \ArrayAccess, \SeekableIterator, \Countable {
    
    /**
     * 
     * @var \ArrayIterator $iterator
     */
    protected $iterator;
    
    

    /**
     * Returns the number of elements.
     *
     * @return integer The number of elements.
     */
    public function count() {
        return $this->iterator->count();
    }

    /**
     * Return the current element.
     *
     * @return mixed The current element.
     */
    abstract public function current();

    /**
     * Return the key of the current element.
     *
     * @return scalar The key of the current element.
     */
    public function key() {
        return $this->iterator->key();
    }

    /**
     * Move the current position to the next element.
     * 
     */
    public function next() {
        $this->iterator->next();
    }

    /**
     * Check whether an offset exists.
     * 
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return $this->iterator->offsetExists($offset);
    }

    /**
     * Return the value at specified offset.
     * 
     * @param mixed $offset
     * @return mixed 
     */
    abstract public function offsetGet($offset);

    /**
     * Assign a value to the specified offset.
     * 
     * @param mixed $offset 
     * @param mixed $value
     */
    abstract public function offsetSet($offset, $value);

    /**
     * Unset an offset.
     * 
     * @param mixed $offset
     */
    abstract public function offsetUnset($offset);

    /**
     * Rewind back to the first element of the Iterator.
     * 
     */
    public function rewind() {
        $this->iterator->rewind();
    }

    /**
     * Seek to a given position in the iterator.
     * 
     * @param type $position
     */
    public function seek($position) {
        $this->iterator->seek($position);
    }

    /**
     * Check if current position is valid.
     * 
     * @return boolean
     */
    public function valid() {
        return $this->iterator->valid();
    }
}

?>