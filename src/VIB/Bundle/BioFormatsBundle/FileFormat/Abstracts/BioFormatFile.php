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
     * @var boolean $fileRead 
     */
    protected $fileIndexed;
    
    /**
     *
     * @var boolean $fileRead 
     */
    protected $fileRead;
    
    /**
     *
     * @var boolean $fileWritten 
     */
    protected $fileWritten;
    
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
     * Set file
     * 
     * @param SplFileObject $file 
     */
    public function setFile(\SplFileObject $file) {
        $this->file = $file;
    }
    
    /**
     * Is the file valid FastA
     * 
     * @return boolean
     */
    public function isValid() {
        if (!$this->fileRead) {
            $this->readFile();
        }
        return $this->fileValid;
    }
    
    /**
     * Read bioformat file
     * 
     * @return integer|boolean Number of entries read or false on error
     */
    abstract public function readFile();
    
    /**
     * Write bioformat file file
     * 
     * @return integer|boolean Number of entries written or false on error
     */
    abstract public function writeFile();
    
}

?>