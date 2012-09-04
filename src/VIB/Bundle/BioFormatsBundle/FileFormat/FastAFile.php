<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use VIB\Bundle\BioBundle\Entity\DNA\Sequence;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts as Abstracts;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\FastAFile
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class FastAFile implements Interfaces\SequenceFile {
    
    protected $sequences;
    protected $file;
    
    /**
     * 
     * @param \VIB\Bundle\BioFormatsBundle\FileFormat\SplFileObject|VIB\Bundle\BioBundle\Entity\DNA\Sequence|Doctrine\Common\Collections\Collection $parameter
     */
    public function __construct(\SplFileObject $file = null,Collection $sequences = null) {
        $this->file = $file;
        if ($sequences == null) {
            $this->sequences = new ArrayCollection();
        } else {
            $this->sequences = $sequences;
        }
    }
    
    /**
     * Get sequences
     * 
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSequences() {
        return $this->sequences;
    }

    /**
     * Add sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Sequence $sequence 
     */
    public function addSequence(Sequence $sequence) {
        $this->sequences[] = $sequence;
    }
        
    /**
     * Remove sequence
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Sequence $sequence 
     */
    public function removeSequence(Sequence $sequence) {
        $this->sequences->removeElement($sequence);
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
        $file = $this->getFile();
        if ($file == null) {
            return false;
        }
        $valid = false;
        foreach ($file as $line) {
            $line = trim($line);
            if ((strlen($line) > 0)&&($line[0] == ">")) {
                $valid = true;
            } elseif ((strlen($line) > 0)&&($line[0] == ";")) {
                $valid = true;
            } elseif (preg_match("/^[aAcCgGtTrRyYkKmMsSwWbBdDhHvVnN]*$/",$line)) {
                $valid = true;
            } else {
                $valid = false;
                break;
            }
        }
        $file->rewind();
        return $valid;
    }
    
    /**
     * Read sequences from FastA file
     * 
     * @return integer|boolean Number of sequences read or false on error
     */
    public function readFile() {
        $file = $this->getFile();
        if ($file == null) {
            return false;
        }
        $sequencesRead = 0;
        while (!$file->eof()) {
            $line = trim($file->current());
            if ((strlen($line) > 0)&&($line[0] == ">")) {
                $sequence = $this->readSequence($file);
                if ($sequence != null) {
                    $this->addSequence($sequence);
                    $sequencesRead++;
                }
            } else {
                $file->next();
            }
        }
        return $sequencesRead;
    }
    
    /**
     * Read single sequence from FastA file
     * 
     * @return \VIB\Bundle\BioBundle\Entity\DNA\Sequence|boolean The sequence read or false on error
     */
    protected function readSequence() {
        $file = $this->getFile();
        if ($file == null) {
            return false;
        }
        $newSequence = true;
        $sequence = new Sequence();
        $sequenceText = "";
        
        while (!$file->eof()) {
            $line = trim($file->current());
            if ((strlen($line) > 0)&&($line[0] == ">")) {
                if ($newSequence) {
                    $this->parseHeader($line, $sequence);
                    $newSequence = false;
                } else {
                    break;
                }
            } elseif ((strlen($line) > 0)&&($line[0] == ";")) {
            } else {
                $sequenceText .= preg_replace('/\s+/','',$line);
            }
            $file->next();
        }
        
        if ((strlen($sequenceText) > 0)&&(!$newSequence)) {
            $sequence->setSequence($sequenceText);
            return $sequence;
        } else {
            return null;
        }
    }
    
    /**
     * Parse the string containing FastA header
     * 
     * @param string $line
     * @param \VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     */
    protected function parseHeader($line, Abstracts\Sequence $sequence) {
        $match = array();
        if (preg_match("/^>(\S+)(.*)$/",$line,$match) === 1) {
            $name = trim($match[1]);
            if (strlen($name) > 0) {
                $sequence->setName($name);
            }
            $description = trim($match[2]);
            if (strlen($description) > 0) {
                $sequence->setDescription($description);
            }
        }
    }
}

?>