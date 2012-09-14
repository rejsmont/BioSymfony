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

use VIB\Bundle\BioFormatsBundle\FileFormat\Collections\SequenceFileCollection;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\FastAFile
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class FastAFile extends Abstracts\BioFormatFile implements Interfaces\SequenceFile {
    
    /**
     *
     * @var Doctrine\Common\Collections\Collection $sequences 
     */
    protected $sequences;
    
    /**
     * 
     * @var array $sequenceIndex
     */
    protected $sequenceIndex;
    
    
    
    /**
     * 
     * @param VIB\Bundle\BioFormatsBundle\FileFormat\SplFileObject $file
     * @param Doctrine\Common\Collections\Collection $sequences
     */
    public function __construct(\SplFileObject $file = null,Collection $sequences = null) {
        parent::__construct($file);
        $this->indexFile();
        $this->sequences = new SequenceFileCollection($this);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSequenceIndex() {
        return $this->sequenceIndex;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSequences() {
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
     * Index sequences in the file
     * 
     * @return boolean
     */
    public function indexFile() {
        $file = $this->getFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if ($line[0] == ">") {
                    $this->indexSequence($line,$file->key());
                }
            }
            $file->next();
        }
        $this->fileIndexed = true;
        return true;
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
        foreach ($this->sequenceIndex as $indexEntry) {
            $this->readSequence($indexEntry);
        }
        $this->fileRead = true;
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
     * Create index entry for sequence
     * 
     * @param string $line 
     * @param integer $lineNumber 
     * @return boolean 
     */
    private function indexSequence($line,$lineNumber) {
        $match = array();
        if (preg_match("/^>(\S+)(.*)$/",$line,$match) === 1) {
            $name = trim($match[1]);
            if (strlen($name) > 0) {
                $this->sequenceIndex[$name] = $lineNumber;
            } else {
                $this->fileValid = false;
                return false;
            }
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function readSequence($indexEntry = false) {
        $file = $this->getFile();
        if ($file == null) {
            $this->fileValid = false;
            return null;
        }
        $newSequence = true;
        $sequence = new Sequence();
        $sequenceText = "";
        if (! isset($this->sequenceIndex[$indexEntry])) {
            return null;
        }
        $file->seek($this->sequenceIndex[$indexEntry]);
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if ($line[0] == ">") {
                    if ($file->eof()) {
                        $this->fileValid = false;
                        return null;
                    }
                    if ($newSequence) {
                        $this->parseFastAHeader($line, $sequence);
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
                         return null;
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
    protected function parseFastAHeader($line, AbstractSequence $sequence) {
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

    public function removeSequenceAtIndex($indexEntry) {
        
    }

    public function replaceSequenceAtIndex($indexEntry, AbstractSequence $sequence) {
        
    }
}

?>