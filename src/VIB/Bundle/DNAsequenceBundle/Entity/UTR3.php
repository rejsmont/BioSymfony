<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\UTR3
 * 
 * @ORM\Entity
 */
class UTR3 extends Feature implements mRNAChild {

    /**
     * @var Collection $mRNAs
     * 
     * @ORM\ManyToMany(targetEntity="mRNA", mappedBy="UTR3s")
     */
    protected $mRNAs;
    
    
    
    public function __construct() {
        $this->mRNAs = new ArrayCollection();
        parent::__construct();
    }

    /**
     * Get mRNA
     * 
     * @return mRNA
     * @return null
     * @return false if CDS is associated with multiple mRNAs
     */
    public function getmRNA() {
        if ($this->mRNAs->count() == 1) {
            return $this->mRNAs->first();
        } else if ($this->mRNAs->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Set mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function setmRNA(mRNA $mRNA,$recurse = true) {
        if ($this->mRNAs->count() > 0) {
            foreach ($this->mRNAs as $remmRNA) {
                $this->removemRNA($remmRNA,$recurse);
            }
        }
        $this->addmRNA($mRNA,$recurse);
    }
    
    /**
     * Get mRNAs
     * 
     * @return Collection 
     */
    public function getmRNAs() {
        return $this->mRNAs;
    }
    
    /**
     * Add mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function addmRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs[] = $mRNA;
        if ($recurse === true) {
            $mRNA->addUTR3($this, false);
        }
    }
        
    /**
     * Remove mRNA
     * 
     * @param mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function removemRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs->removeElement($mRNA);
        if ($recurse === true) {
            $mRNA->removeUTR3($mRNA, false);
        }
    }
    
    /**
     * Get gene
     * 
     * @return Gene
     * @return false if mRNA is polycistronic
     */
    public function getGene() {
        $genes = $this->getGenes();
        if ($genes->count() == 1) {
            return $genes->first();
        } else if ($genes->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Get genes
     * 
     * @return Collection
     */
    public function getGenes() {
        $genes = new ArrayCollection();
        foreach ($this->mRNAs as $mRNA) {
            foreach ($mRNA->getGenes() as $gene) {
                if ((!$genes->contains($gene))&&((!$mRNA->isPolycistronic())||($this->getOrigin() == $gene))) {
                    $genes->add($gene);
                }
            }
        }
    }
    
    /**
     * Get parents
     * 
     * @return Collection  
     */
    public function getParents() {
        $parents = parent::getParents();
        foreach ($this->mRNAs as $mRNA) {
            if (!$parents->contains($mRNA)) {
                $parents->add($mRNA);
            }
        }
        return $parents;
    }
    
    /**
     * Add parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function addParent(Feature $parent,$recurse = true) {
        if ($parent instanceof mRNA) {
            $this->addmRNA($parent,$recurse);
        } else {
            parent::addParent($parent, $recurse);
        }
    }
        
    /**
     * Remove parent
     * 
     * @param Feature $parent 
     * @param boolean $recurse 
     */
    public function removeParent(Feature $parent,$recurse = true) {
        if ($parent instanceof mRNA) {
            $this->removemRNA($parent,$recurse);
        } else {
            parent::removeParent($parent, $recurse);
        }
    }
}

?>