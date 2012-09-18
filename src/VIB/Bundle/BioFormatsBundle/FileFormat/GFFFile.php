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

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature;
use VIB\Bundle\BioFormatsBundle\FileFormat\Features\GFFFeature;

/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\GFFFile
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class GFFFile extends FastAFile implements Interfaces\AnnotationsFile {
    
    /**
     *
     * @var Doctrine\Common\Collections\Collection $features 
     */
    public $features;
    
    /**
     * 
     * @var array $featureIndex
     */
    public $featureIndex;
    
    
    
    /**
     * Index sequences and features in the file
     * 
     * @return boolean
     */
    public function indexFile() {
        $file = $this->getWorkingFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if (substr($line, 0, 7) == "##FASTA") {
                    parent::indexFile();
                } elseif ($line[0] != "#") {
                    $this->indexFeature($line,$file->key());
                }
            }
            $file->next();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function readFile() {
        $file = $this->getWorkingFile();
        if ($file == null) {
            $this->fileValid = false;
            return false;
        }
        $sequencesRead = 0;
        while (!$file->eof()) {
            $line = trim($file->current());
            if (strlen($line) > 0) {
                if (substr($line, 0, 7) == "##FASTA") {
                    $file->next();
                    parent::readFile();
                } elseif ($line[0] != "#") {
                    $feature = $this->parseFeature($line);
                    if ($feature instanceof GFFFeature) {
                        $this->features[] = $feature;
                    } elseif ($feature !== null) {
                        $this->fileValid = false;
                        return false;
                    }
                }
            }
            $file->next();
        }
        $this->fileRead = true;
        return $sequencesRead;
    }
    
    /**
     * {@inheritDoc}
     */
    public function writeFile() {
        $file = $this->getWorkingFile();
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
     * Create index entry for feature
     * 
     * @param string $line 
     * @param integer $lineNumber 
     * @return boolean 
     */
    private function indexFeature($line,$lineNumber) {
        $fields = explode("\t", $line);        
        if (count($fields) != 9) {
            return false;
        }
        list($seqID, , , , , , , ,$attrLine) = $fields;
        if (trim($seqID) == "") {
            $this->fileValid = false;
            return false;
        }
        $featureID = "undef_" . $lineNumber;
        foreach (explode(";",$attrLine) as $attrString) {
            list($field,$value) = explode("=",$attrString);
            if (strtolower(trim($field)) == "id") {
                $featureID = trim($value);
                if (strlen($featureID) > 0) {
                    break;
                } else {
                    $this->fileValid = false;
                    return false;
                }
            }
        }
        if (isset($this->featureIndex[$seqID][$featureID])) {
            $this->featureIndex[$seqID][$featureID] .= "," . $lineNumber;
        } else
            $this->featureIndex[$seqID][$featureID] = $lineNumber;
        return true;
    }
    
    /**
     * Parse GFF feature line
     * 
     * @param string $line 
     * @return VIB\Bundle\BioFormatsBundle\FileFormat\Features\GFFFeature|boolean The GFF feature read or false on error
     */
    private function parseFeature($line) {
        
        $fields = explode("\t", $line);        
        if (count($fields) != 9) {
            return false;
        }
                
        $GFFFeature = new GFFFeature($fields);
        
        if(($GFFFeature->getType() != "match")&&($GFFFeature->getType() != "match_part"))
            return $GFFFeature;
        else
            return null;
    }
}

?>