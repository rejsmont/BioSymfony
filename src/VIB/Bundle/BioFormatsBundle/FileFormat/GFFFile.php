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
                if (substr($line, 0, 6) == "##FASTA") {
                    $file->next();
                    parent::readFile();
                } elseif ($line[0] != "#") {
                    $feature = $this->parseFeature($line);
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
        
        return $GFFFeature;
    }
}

?>