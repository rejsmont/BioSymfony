<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Abstracts;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Abstracts\BioFormatFile
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
abstract class BioFormatFile {
    
    /**
     *
     * @var SplFileObject $file 
     */
    protected $file;
    
    /**
     *
     * @var SplTempFileObject $file 
     */
    protected $tmpfile;
    
    /**
     *
     * @var boolean $fileIndexed 
     */
    protected $fileIndexed;
    
    /**
     *
     * @var boolean $fileModified 
     */
    protected $fileModified;
    
    /**
     *
     * @var boolean $fileValid 
     */
    protected $fileValid;
    
    
    
    /**
     * 
     * @param VIB\Bundle\BioFormatsBundle\FileFormat\SplFileObject $file 
     */
    public function __construct(\SplFileObject $file = null) {
        $this->fileIndexed = false;
        $this->fileModified = false;
        $this->fileValid = null;
        $this->file = $file;
        $this->tmpfile = null;
    }
    
    /**
     * Get file
     * 
     * @return SplFileObject
     */
    public function getFile() {
        return $this->file;
    }
    
    /**
     * Get working copy of the file
     * 
     * @return SplFileObject
     */
    public function getWorkingFile() {
        if ($this->tmpfile !== null) {
            return $this->tmpfile;
        } else {
            return $this->file;
        }
    }
    
    /**
     * Get writable copy of the file
     * 
     * @return SplFileObject
     */
    protected function getWritableFile() {
        if ($this->tmpfile === null) {
            $this->tmpfile = new \SplTempFileObject(131072);
            $this->file->rewind();
            foreach($this->file as $line) {
                $this->tmpfile->fwrite($line);
            }
        }
        return $this->tmpfile;
    }
    
    /**
     * Set file
     * 
     * @param SplFileObject $file 
     */
    public function setFile(\SplFileObject $file) {
        $this->file = $file;
    }
    
    /**
     * Is the file valid 
     * 
     * @return boolean TRUE if the file is valid, FALSE otherwise
     */
    public function isValid() {
        if (!$this->fileIndexed) {
            $this->indexFile();
        }
        return $this->fileValid;
    }
    
    /**
     * Save the file
     * 
     * @return integer|boolean Number of entries written, TRUE if file was not modified or FALSE on error
     */
    abstract public function save();
    
}

?>