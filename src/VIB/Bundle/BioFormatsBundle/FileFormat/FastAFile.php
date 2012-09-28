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

use Symfony\Component\Filesystem\Exception\IOException;

use VIB\Bundle\BioBundle\Entity\DNA\Sequence;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence as AbstractSequence;

use VIB\Bundle\BioFormatsBundle\FileFormat\Collections\SequenceFileCollection;
use VIB\Bundle\BioFormatsBundle\Exceptions\FileFormatException;
use VIB\Bundle\BioFormatsBundle\Exceptions\InvalidIndexException;

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
     * {@inheritDoc}
     */
    public function updateSequence(AbstractSequence $sequence) {
        $this->sequences->set($sequence->getName(), $sequence);
    }
    
    /**
     * Index sequences in the file
     * 
     * @return boolean TRUE on success
     */
    protected function indexFile() {
        $this->file = $this->file->openFile("r");
        if ($this->fileIndexed === true) {
            return true;
        }
        $file = $this->getWorkingFile();
        if ($file == null) {
            throw new IOException("Cannot open file for reading.");
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
        if (! $this->fileModified) {
            return true;
        }
        if ($this->tmpfile == null) {
            throw new IOException("Cannot open temporary file for reading.");
        }
        $this->file = $this->file->openFile("w");
        $sequencesWritten = 0;
        foreach ($this->sequences as $sequence) {
            $this->writeSequence($sequence, true);
            $sequencesWritten++;
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
            throw new IOException("Cannot open file for reading.");
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
                        throw new FileFormatException("Sequence is empty.");
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
                         throw new FileFormatException("Unsupported characters in the sequence.");
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
            $this->fileValid = false;
            throw new FileFormatException("Sequence is empty.");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function putSequence($indexEntry, AbstractSequence $sequence) {
        $file = $this->getWritableFile();
        if ($file == null) {
            throw new IOException("Cannot open file for writing.");
        }
        if ($file->fseek(0,SEEK_END) != 0) {
            throw new IOException("Cannot write to the file.");
        }
        if ($indexEntry == null) {
            $indexEntry = $sequence->getName();
            if (strlen($indexEntry) == 0) {
                throw new InvalidIndexException("Sequence name is empty.");
            }
            if (array_key_exists($indexEntry, $this->sequenceIndex)) {
                throw new InvalidIndexException("Sequence name is not unique.");
            }
        }
        $position = $this->writeSequence($sequence);
        $this->sequenceIndex[$indexEntry] = $position;
        $this->fileModified = true;
        return $indexEntry;
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteSequence($indexEntry) {
        if (isset($this->sequenceIndex[$indexEntry])) {
            $this->getWritableFile();
            unset($this->sequenceIndex[$indexEntry]);
            $this->fileModified = true;
        }
    }

    /**
     * Create index entry for a sequence
     * 
     * @param string $line 
     * @param integer $lineNumber 
     */
    private function indexSequence($line,$position) {
        $match = array();
        if (preg_match("/^>(\S+)(.*)$/",$line,$match) === 1) {
            $indexEntry = rawurldecode(trim($match[1]));
            if (strlen($indexEntry) > 0) {
                if (array_key_exists($indexEntry, $this->sequenceIndex)) {
                    throw new FileFormatException("Sequence name is not unique.");
                }
                $this->sequenceIndex[$indexEntry] = $position;
            } else {
                throw new FileFormatException("Sequence name is empty.");
            }
        } else {
            throw new FileFormatException("Invalid FastA header.");
        }
    }
    
    /**
     * Write single sequence to FastA file
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Sequence $sequence 
     * @return integer Position of the sequence in the file
     */
    protected function writeSequence(AbstractSequence $sequence, $saveMode = false) {
        $file = ($saveMode ? $this->getFile() : $this->getWorkingFile());
        if ($file == null) {
            throw new IOException("Cannot open file for writing.");
        }
        if (($sequence != null)||(strlen($sequence->getSequence()) > 0)) {
            throw new FileFormatException("Sequence is empty.");
        }
        if (strlen($sequence->getName()) > 0) {
            throw new FileFormatException("Sequence name is empty.");
        }
        $position = $file->ftell();
        $file->fwrite(">");
            $file->fwrite(rawurlencode($sequence->getName()));
        if (strlen($sequence->getDescription()) > 0) {
            $file->fwrite(' ' . $sequence->getDescription());
        }
        $file->fwrite("\n");
        $file->fwrite(wordwrap($sequence->getSequence(),75,"\n",true));
        $file->fwrite("\n");
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
            $name = rawurldecode(trim($match[1]));
            if (strlen($name) > 0) {
                $sequence->setName($name);
            } else {
                throw new FileFormatException("Sequence name is empty.");
            }
            $description = trim($match[2]);
            if (strlen($description) > 0) {
                $sequence->setDescription($description);
            }
        }
    }
}

?>