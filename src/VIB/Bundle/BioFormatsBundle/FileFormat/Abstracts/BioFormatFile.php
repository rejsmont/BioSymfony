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
     * @var boolean $fileRead 
     */
    protected $fileRead;
    
    /**
     *
     * @var boolean $fileSaved 
     */
    protected $fileSaved;
    
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
        $this->fileRead = false;
        $this->fileWritten = false;
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
    protected function getWorkingFile() {
        if ($this->tmpfile !== null) {
            return $this->tmpfile;
        } else {
            return $this->file;
        }
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
        if (!$this->fileRead) {
            $this->readFile();
        }
        return $this->fileValid;
    }
    
    /**
     * Save the file
     * 
     * @return integer|boolean Number of entries written or FALSE on error
     */
    abstract public function save();
    
}

?>