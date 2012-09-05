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
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence as AbstractSequence;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\FastAFile
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class FastAFile extends Abstracts\BioFormatFile implements Interfaces\SequenceFile {
    
    protected $sequences;
    
    /**
     * 
     * @param VIB\Bundle\BioFormatsBundle\FileFormat\SplFileObject $file
     * @param Doctrine\Common\Collections\Collection $sequences
     */
    public function __construct(\SplFileObject $file = null,Collection $sequences = null) {
        parent::__construct($file);
        if ($sequences == null) {
            $this->sequences = new ArrayCollection();
        } else {
            $this->sequences = $sequences;
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSequences() {
        if (($this->sequences->count() == 0)&&(!$this->fileRead)) {
            $this->readFile();
        }
        return $this->sequences;
    }

    /**
     * {@inheritDoc}
     */
    public function addSequence(AbstractSequence $sequence) {
        $this->sequences[] = $sequence;
    }
        
    /**
     * {@inheritDoc}
     */
    public function removeSequence(AbstractSequence $sequence) {
        $this->sequences->removeElement($sequence);
    }
    
    /**
     * {@inheritDoc}
     */
    public function readFile() {
        $file = $this->getFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        $sequencesRead = 0;
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if ($line[0] == ">") {
                    $sequence = $this->readSequence($file);
                    if ($sequence instanceof Sequence) {
                        $this->addSequence($sequence);
                        $sequencesRead++;
                        $this->fileValid = true;
                    } else {
                        $this->fileValid = false;
                        $file->rewind();
                        return false;
                    }
                    continue;
                } elseif ($line[0] != ";") {
                    $this->fileValid = false;
                    $file->rewind();
                    return false;
                }
            }
            $file->next();
        }
        $this->fileRead = true;
        $file->rewind();
        return $sequencesRead;
    }
    
    /**
     * {@inheritDoc}
     */
    public function writeFile() {
        $file = $this->getFile();
        if (($file == null)||($this->sequences->count() == 0)||(!$file->isWritable())) {
            return false;
        }
        $sequencesWritten = 0;
        
        foreach ($this->sequences as $sequence) {
            if ($this->writeSequence($sequence)) {
                $sequencesWritten++;
            } else {
                return false;
            }
        }
        
        return $sequencesWritten;
    }
    
    /**
     * Read single sequence from FastA file
     * 
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence|boolean The sequence read or false on error
     */
    protected function readSequence() {
        $file = $this->getFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        $newSequence = true;
        $sequence = new Sequence();
        $sequenceText = "";
        
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if ($line[0] == ">") {
                    if ($file->eof()) {
                        $this->fileValid = false;
                        return false;
                    }
                    if ($newSequence) {
                        $this->parseHeader($line, $sequence);
                        $sequenceText = "";
                        $newSequence = false;
                    } else {
                        break;
                    }
                } elseif ($line[0] != ";") {
                     $line = preg_replace('/\s+/','',$line);
                     if (preg_match("/^[aAcCgGtTrRyYkKmMsSwWbBdDhHvVnN]+$/",$line)) {
                        $sequenceText .= $line;
                     } elseif (strlen($line) == 0) {
                         break;
                     } else {
                         $this->fileValid = false;
                         return false;
                     }
                }
            } else {
                break;
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
     * Write single sequence to FastA file
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     * @return boolean 
     */
    protected function writeSequence(AbstractSequence $sequence) {
        $file = $this->getFile();
        if (($file != null)||($sequence != null)||($file->isWritable())&&(strlen($sequence->getSequence()) > 0)) {
            $file->fwrite(">");
            if (strlen($sequence->getName()) > 0) {
                $file->fwrite($sequence->getName());
            }
            if (strlen($sequence->getDescription()) > 0) {
                $file->fwrite(' ' . $sequence->getDescription());
            }
            $file->fwrite("\n");
            $file->fwrite(wordwrap($sequence->getSequence(),75,"\n",true));
            $file->fwrite("\n");
            return true;
        }
        return false;
    }
    
    /**
     * Parse the string containing FastA header
     * 
     * @param string $line
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence
     */
    protected function parseHeader($line, AbstractSequence $sequence) {
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