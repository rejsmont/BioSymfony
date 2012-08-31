<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Feature;
use VIB\Bundle\BioBundle\Entity\DNA\Abstracts as Abstracts;

/**
 * VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Gene
 * 
 * @ORM\Entity
 */
class Gene extends Feature {

    /**
     * @var Doctrine\Common\Collections\Collection $mRNAs
     * 
     * @ORM\ManyToMany(targetEntity="mRNA", inversedBy="genes")
     * @ORM\JoinTable(name="DNAmRNAs",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mRNA_id", referencedColumnName="id")}
     *      )
     */
    protected $mRNAs;
    
    /**
     * @var Doctrine\Common\Collections\Collection $exons
     * 
     * @ORM\ManyToMany(targetEntity="exon", inversedBy="genes")
     * @ORM\JoinTable(name="DNAexons",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="exon_id", referencedColumnName="id")}
     *      )
     */
    protected $exons;
    
    /**
     * @var Doctrine\Common\Collections\Collection $introns
     * 
     * @ORM\ManyToMany(targetEntity="intron", inversedBy="genes")
     * @ORM\JoinTable(name="DNAintrons",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="intron_id", referencedColumnName="id")}
     *      )
     */
    protected $introns;
    
    
    
    public function __construct() {
        $this->mRNAs = new ArrayCollection();
        $this->exons = new ArrayCollection();
        $this->introns = new ArrayCollection();
        parent::__construct();
    }
    
    /**
     * Get mRNAs
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getmRNAs() {
        return $this->mRNAs;
    }
    
    /**
     * Add mRNA
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function addmRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs[] = $mRNA;
        if ($recurse === true) {
            $mRNA->addGene($this, false);
        }
    }
        
    /**
     * Remove mRNA
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\mRNA $mRNA 
     * @param boolean $recurse 
     */
    public function removemRNA(mRNA $mRNA,$recurse = true) {
        $this->mRNAs->removeElement($mRNA);
        if ($recurse === true) {
            $mRNA->removeGene($this, false);
        }
    }
    
    /**
     * Get exons
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getExons() {
        return $this->exons;
    }
    
    /**
     * Add exon
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Exon $exon 
     * @param boolean $recurse 
     */
    public function addExon(Exon $exon,$recurse = true) {
        $this->exons[] = $exon;
        if ($recurse === true) {
            $exon->addGene($this, false);
        }
    }
        
    /**
     * Remove exon
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Exon $exon 
     * @param boolean $recurse 
     */
    public function removeExon(Exon $exon,$recurse = true) {
        $this->exons->removeElement($exon);
        if ($recurse === true) {
            $exon->removeGene($this, false);
        }
    }
    
    /**
     * Get introns
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIntrons() {
        return $this->introns;
    }
    
    /**
     * Add intron
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Intron $intron 
     * @param boolean $recurse 
     */
    public function addIntron(Intron $intron,$recurse = true) {
        $this->introns[] = $intron;
        if ($recurse === true) {
            $intron->addGene($this, false);
        }
    }
        
    /**
     * Remove intron
     * 
     * @param VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\Intron $intron 
     * @param boolean $recurse 
     */
    public function removeIntron(Intron $intron,$recurse = true) {
        $this->introns->removeElement($intron);
        if ($recurse === true) {
            $intron->removeGene($this, false);
        }
    }
    
    /**
     * Get UTR5s
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUTR5s() {      
        $UTR5s = new ArrayCollection();
        foreach($this->mRNAs as $mRNA) {
            foreach ($mRNA->getUTR5s() as $UTR5) {
                if ((!$UTR5s->contains($UTR5))&&((!$mRNA->isPolycistronic())||($UTR5->getOrigin() == $this))) {
                    $UTR5s->add($UTR5);
                }
            }
        }
        return $UTR5s;
    }
    
    /**
     * Get UTR3s
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUTR3s() {      
        $UTR3s = new ArrayCollection();
        foreach($this->mRNAs as $mRNA) {
            foreach ($mRNA->getUTR3s() as $UTR3) {
                if ((!$UTR3s->contains($UTR3))&&((!$mRNA->isPolycistronic())||($UTR3->getOrigin() == $this))) {
                    $UTR3s->add($UTR3);
                }
            }
        }
        return $UTR3s;
    }
    
    /**
     * Get CDSs
     * 
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCDSs() {      
        $CDSs = new ArrayCollection();
        foreach($this->mRNAs as $mRNA) {
            foreach ($mRNA->getCDSs() as $CDS) {
                if ((!$CDSs->contains($CDS))&&((!$mRNA->isPolycistronic())||($CDS->getOrigin() == $this))) {
                    $CDSs->add($CDS);
                }
            }
        }
        return $CDSs;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getChildren() {
        $children = parent::getChildren();
        foreach ($this->exons as $exon) {
            if (!$children->contains($exon)) {
                $children->add($exon);
            }
        }
        foreach ($this->introns as $intron) {
            if (!$children->contains($intron)) {
                $children->add($intron);
            }
        }
        foreach ($this->mRNAs as $mRNA) {
            if (!$children->contains($mRNA)) {
                $children->add($mRNA);
            }
        }
        return $children;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addChild(Abstracts\Feature $child,$recurse = true) {
        if($child instanceof Exon) {
            $this->addExon($child,$recurse);
        } elseif ($child instanceof Intron) {
            $this->addIntron($child,$recurse);
        } elseif ($child instanceof mRNA) {
            $this->addmRNA($child,$recurse);
        } else {
            parent::addChild($child, $recurse);
        }
    }
        
    /**
     * {@inheritDoc}
     */
    public function removeChild(Abstracts\Feature $child,$recurse = true) {
        if($child instanceof Exon) {
            $this->removeExon($child,$recurse);
        } elseif ($child instanceof Intron) {
            $this->removeIntron($child,$recurse);
        } elseif ($child instanceof mRNA) {
            $this->removemRNA($child,$recurse);
        } else {
            parent::removeChild($child, $recurse);
        }
    }
}

?>