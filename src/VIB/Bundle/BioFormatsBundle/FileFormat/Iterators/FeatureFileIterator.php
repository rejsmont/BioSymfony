<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioFormatsBundle\FileFormat\Collections;

use Doctrine\Common\Collections\Criteria;
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
 * VIB\Bundle\BioFormatsBundle\FileFormat\Collections\FeatureFileCollection
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class FeatureFileCollection implements Collection, Selectable {
    
    
    
    public function add($element) {
        
    }

    public function clear() {
        
    }

    public function contains($element) {
        
    }

    public function containsKey($key) {
        
    }

    public function count() {
        
    }

    public function current() {
        
    }

    public function exists(Closure $p) {
        
    }

    public function filter(Closure $p) {
        
    }

    public function first() {
        
    }

    public function forAll(Closure $p) {
        
    }

    public function get($key) {
        
    }

    public function getIterator() {
        
    }

    public function getKeys() {
        
    }

    public function getValues() {
        
    }

    public function indexOf($element) {
        
    }

    public function isEmpty() {
        
    }

    public function key() {
        
    }

    public function last() {
        
    }

    public function map(Closure $func) {
        
    }

    public function matching(Criteria $criteria) {
        
    }

    public function next() {
        
    }

    public function offsetExists($offset) {
        
    }

    public function offsetGet($offset) {
        
    }

    public function offsetSet($offset, $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

    public function partition(\Closure $p) {
        
    }

    public function remove($key) {
        
    }

    public function removeElement($element) {
        
    }

    public function set($key, $value) {
        
    }

    public function slice($offset, $length = null) {
        
    }

    public function toArray() {
        
    }
}

?>