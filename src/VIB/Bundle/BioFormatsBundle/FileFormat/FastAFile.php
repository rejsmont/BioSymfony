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
        $this->sequenceIndex = array();
        $this->indexFile();
        $this->sequences = new SequenceFileCollection($this, $sequences);
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
     * @return boolean TRUE on success, FALSE on error
     */
    protected function indexFile() {
        $this->file = $this->file->openFile("r");
        if ($this->fileIndexed === true) {
            return true;
        }
        $file = $this->getWorkingFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        while (!$file->eof()) {
            $position = $file->ftell();
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if ($line[0] == ">") {
                    $this->indexSequence($line,$position);
                }
            }
            $file->next();
        }
        return $this->fileIndexed = true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function save() {
        if (!$this->fileModified) {
            return true;
        }
        if ($this->tmpfile == null) {
            return false;
        }
        $this->file = $this->file->openFile("w");
        $sequencesWritten = 0;
        foreach ($this->sequences as $key => $sequence) {
            if ($this->writeSequence($sequence, true) !== null) {
                $sequencesWritten++;
            } else {
                return false;
            }
        }
        $this->fileModified = false;
        $this->fileIndexed = false;
        $this->fileValid = null;
        $this->tmpfile = null;
        $this->sequenceIndex = array();
        $this->indexFile();
        return $sequencesWritten;
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
    public function readSequence($indexEntry = false) {
        $file = $this->getWorkingFile();
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
        $file->fseek($this->sequenceIndex[$indexEntry]);
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
     * {@inheritDoc}
     */
    public function appendSequence(AbstractSequence $sequence) {
        return $this->replaceSequence(null, $sequence);
    }

    /**
     * {@inheritDoc}
     */
    public function replaceSequence($indexEntry, AbstractSequence $sequence) {
        $file = $this->getWritableFile();
        if ($file->fseek(0,SEEK_END) != 0) {
            return false;
        }
        if ($indexEntry == null) {
            $indexEntry = $sequence->getName();
            if (strlen($indexEntry) == 0) {
                return false;
            }
            if (array_key_exists($indexEntry, $this->sequenceIndex)) {
                $suffix = 1;
                while (array_key_exists($indexEntry . "_" . $suffix, $this->sequenceIndex)) {
                    $suffix++;
                }
                $indexEntry = $indexEntry . "_" . $suffix;
            }
        }
        $position = $this->writeSequence($sequence);
        if ($position !== false) {
            $this->sequenceIndex[$indexEntry] = $position;
            $this->fileModified = true;
            return $indexEntry;
        }
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteSequence($indexEntry) {
        $this->getWritableFile();
        unset($this->sequenceIndex[$indexEntry]);
        $this->fileModified = true;
    }

    /**
     * Create index entry for a sequence
     * 
     * @param string $line 
     * @param integer $lineNumber 
     * @return boolean 
     */
    private function indexSequence($line,$position) {
        $match = array();
        if (preg_match("/^>(\S+)(.*)$/",$line,$match) === 1) {
            $indexEntry = trim($match[1]);
            if (strlen($indexEntry) > 0) {
                if (array_key_exists($indexEntry, $this->sequenceIndex)) {
                    $suffix = 1;
                    while (array_key_exists($indexEntry . "_" . $suffix, $this->sequenceIndex)) {
                        $suffix++;
                    }
                    $indexEntry = $indexEntry . "_" . $suffix;
                }
                $this->sequenceIndex[$indexEntry] = $position;
            } else {
                $this->fileValid = false;
                return false;
            }
        }
        return true;
    }
    
    /**
     * Write single sequence to FastA file
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     * @return integer|boolean Position of the sequence in the file or FALSE on error
     */
    protected function writeSequence(AbstractSequence $sequence, $saveMode = false) {
        $file = ($saveMode ? $this->getFile() : $this->getWorkingFile());
        $position = false;
        if (($file != null)&&($sequence != null)&&(strlen($sequence->getSequence()) > 0)) {
            $position = $file->ftell();
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
        }
        return $position;
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
}

?>