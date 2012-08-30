<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Gene
 * 
 * @ORM\Entity
 */
class Gene extends Feature {

    /**
     * @var Collection $mRNAs
     * 
     * @ORM\ManyToMany(targetEntity="mRNA", inversedBy="genes")
     * @ORM\JoinTable(name="DNAmRNAs",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mRNA_id", referencedColumnName="id")}
     *      )
     */
    protected $mRNAs;
    
    /**
     * @var Collection $exons
     * 
     * @ORM\ManyToMany(targetEntity="exon", inversedBy="genes")
     * @ORM\JoinTable(name="DNAexons",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="exon_id", referencedColumnName="id")}
     *      )
     */
    protected $exons;
    
    /**
     * @var Collection $introns
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
            $mRNA->addGene($this, false);
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
            $mRNA->removeGene($this, false);
        }
    }
    
    /**
     * Get exons
     * 
     * @return Collection 
     */
    public function getExons() {
        return $this->exons;
    }
    
    /**
     * Add exon
     * 
     * @param Exon $exon 
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
     * @param Exon $exon 
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
     * @return Collection 
     */
    public function getmRNAs() {
        return $this->introns;
    }
    
    /**
     * Add intron
     * 
     * @param Intron $intron 
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
     * @param Intron $intron 
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
     * @return Collection 
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
     * @return Collection 
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
     * @return Collection 
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
     * Get children
     * 
     * @return Collection 
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
     * Add child
     * 
     * @param Feature $child 
     * @param boolean $recurse 
     */
    public function addChild(Feature $child,$recurse = true) {
        if($child instanceof Exon) {
            $this->addExon($child,$recurse);
        } else if ($child instanceof Intron) {
            $this->addIntron($child,$recurse);
        } else if ($child instanceof mRNA) {
            $this->addmRNA($child,$recurse);
        } else {
            parent::addChild($child, $recurse);
        }
    }
        
    /**
     * Remove child
     * 
     * @param Feature $child 
     * @param boolean $recurse 
     */
    public function removeChild(Feature $child,$recurse = true) {
        if($child instanceof Exon) {
            $this->removeExon($child,$recurse);
        } else if ($child instanceof Intron) {
            $this->removeIntron($child,$recurse);
        } else if ($child instanceof mRNA) {
            $this->removemRNA($child,$recurse);
        } else {
            parent::removeChild($child, $recurse);
        }
    }
}

?>