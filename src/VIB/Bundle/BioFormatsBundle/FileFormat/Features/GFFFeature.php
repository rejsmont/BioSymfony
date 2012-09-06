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

use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature as AbstractFeature;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureAlias as AbstractFeatureAlias;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\FeatureTag as AbstractFeatureTag;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Location as AbstractLocation;

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\FeatureAlias;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\FeatureTag;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Location;

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Exon;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Intron;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\CDS;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\UTR5;
use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\UTR3;


/**
 * VIB\Bundle\BioFormatsBundle\FileFormat\Features\GFFFeature
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class GFFFeature {
    
    /**
     *
     * @var string $id 
     */
    private $id;
    
    /**
     *
     * @var string $name 
     */
    private $name;
    
    /**
     *
     * @var string $seqID 
     */
    private $seqID;
    
    /**
     *
     * @var string $source 
     */
    private $source;
    
    /**
     *
     * @var string $type  
     */
    private $type;
    
    /**
     *
     * @var float $score 
     */
    private $score;
    
    /**
     * @var Doctrine\Common\Collections\Collection $aliases
     */
    protected $aliases;
    
    /**
     *
     * @var Doctrine\Common\Collections\Collection $locations 
     */
    private $locations;
    
    /**
     *
     * @var Doctrine\Common\Collections\Collection $attributes 
     */
    private $attributes;
    
    /**
     * @var Doctrine\Common\Collections\Collection $parents
     */
    private $parents;
    
    /**
     * @var array $parentIDs
     */
    private $parentIDs;
    
    /**
     * @var Doctrine\Common\Collections\Collection $origins
     */
    private $origins;
    
    /**
     * @var array $originIDs
     */
    private $originIDs;
    
    
    /**
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature|array
     */
    public function __construct($feature) {
        
        $this->attributes = new ArrayCollection();
        $this->locations = new ArrayCollection();
        
        if ($feature instanceof AbstractFeature) {
            
        } elseif ((is_array($feature))&&(count($feature) == 9)) {
            list($this->seqID,
                 $this->source,
                 $this->type,
                 $start,
                 $end,
                 $this->score,
                 $strand,
                 $phase,
                 $attrLine) = $feature;
            
            foreach (explode(";",$attrLine) as $attrString) {
                list($field,$values) = explode($attrString);
                switch(strtolower($field)) {
                    case 'id':
                        $this->id = trim($values);
                        break;
                    case 'name':
                        $this->name = trim($values);
                        break;
                    case 'alias':
                        foreach(explode(",",$values) as $alias) {
                            $this->aliases[] = new FeatureAlias(trim($alias));
                        }
                        break;
                    case 'parent':
                        foreach(explode(",",$values) as $parentID) {
                            $this->parentIDs[] = $parentID;
                        }
                        break;
                    case 'derives_from':
                        foreach(explode(",",$values) as $originID) {
                            $this->originIDs[] = $originID;
                        }
                        break;
                    case 'note':
                        break;
                    case 'target':          // Not implemented
                    case 'gap':             // Not implemented
                    case 'is_circular':     // Not implemented
                    case 'dbxref':          // Not implemented
                    case 'ontology_term':   // Not implemented
                    default:
                        foreach(explode(",",$values) as $value) {
                            $this->attributes[] = new FeatureTag(trim($field),trim($value));
                        }
                }
                
            }
            
            $this->locations->add(new Location(trim($start),trim($end),trim($strand)));
        }
    }
    
    /**
     * Get Feature instance
     * 
     * @return VIB\Bundle\BioBundle\Entity\DNA\Abstracts\Feature
     */
    private function getFeature() {
                        
        switch(strtolower($this->type)) {
            case "gene":    $feature = new Gene();
                            break;
            case "exon":    $feature = new Exon();
                            break;
            case "intron":  $feature = new Intron();
                            break;
            case "mrna":    $feature = new mRNA();
                            break;
            case "cds":     $feature = new CDS();
                            break;
            case "3'utr":   $feature = new UTR3();
                            break;
            case "5'utr":   $feature = new UTR5();
                            break;
            default:        $feature = new Feature();
                            break;
        }
        
        return $feature;
    }
}

?>