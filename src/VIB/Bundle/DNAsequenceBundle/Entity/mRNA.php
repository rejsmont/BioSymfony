<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\mRNA
 * 
 * @ORM\Entity
 */
class mRNA extends Feature implements GeneChild {

    /**
     * @var Collection $CDSs
     * 
     * @ORM\ManyToMany(targetEntity="CDS", inversedBy="mRNAs")
     * @ORM\JoinTable(name="DNA_CDSs",
     *      joinColumns={@ORM\JoinColumn(name="mRNA_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="CDS_id", referencedColumnName="id")}
     *      )
     */
    protected $CDSs;

    /**
     * @var Collection $UTR5s
     * 
     * @ORM\ManyToMany(targetEntity="UTR5", inversedBy="mRNAs")
     * @ORM\JoinTable(name="DNA_UTR5s",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="UTR5_id", referencedColumnName="id")}
     *      )
     */
    protected $UTR5s;
    
    /**
     * @var Collection $UTR3s
     * 
     * @ORM\ManyToMany(targetEntity="UTR3", inversedBy="mRNAs")
     * @ORM\JoinTable(name="DNA_UTR3s",
     *      joinColumns={@ORM\JoinColumn(name="gene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="UTR3_id", referencedColumnName="id")}
     *      )
     */
    protected $UTR3s;
    
    /**
     * @var Collection $genes
     * 
     * @ORM\ManyToMany(targetEntity="Gene", mappedBy="mRNAs")
     */
    protected $genes;

    
    
    public function __construct() {
        $this->CDSs = new ArrayCollection();
        $this->UTR5s = new ArrayCollection();
        $this->UTR3s = new ArrayCollection();
        $this->genes = new ArrayCollection();
        parent::__construct();
    }
    
    /**
     * Get CDSs
     * 
     * @return Collection 
     */
    public function getCDSs() {
        return $this->CDSs;
    }
    
    /**
     * Add CDS
     * 
     * @param CDS $CDS 
     * @param boolean $recurse 
     */
    public function addCDS(CDS $CDS,$recurse = true) {
        $this->CDSs[] = $CDS;
        if ($recurse === true) {
            $CDS->addmRNA($this, false);
        }
    }
        
    /**
     * Remove CDS
     * 
     * @param CDS $CDS 
     * @param boolean $recurse 
     */
    public function removeCDS(CDS $CDS,$recurse = true) {
        $this->CDSs->removeElement($CDS);
        if ($recurse === true) {
            $CDS->removemRNA($this, false);
        }
    } 
    
    /**
     * Get UTR5s
     * 
     * @return Collection 
     */
    public function getUTR5s() {
        return $this->UTR5s;
    }
    
    /**
     * Add UTR5
     * 
     * @param UTR5 $UTR5 
     * @param boolean $recurse 
     */
    public function addUTR5(UTR5 $UTR5,$recurse = true) {
        $this->UTR5s[] = $UTR5;
        if ($recurse === true) {
            $UTR5->addmRNA($this, false);
        }
    }
        
    /**
     * Remove UTR5
     * 
     * @param UTR5 $UTR5 
     * @param boolean $recurse 
     */
    public function removeUTR5(UTR5 $UTR5,$recurse = true) {
        $this->UTR5s->removeElement($UTR5);
        if ($recurse === true) {
            $UTR5->removemRNA($this, false);
        }
    }
    
    /**
     * Get UTR3s
     * 
     * @return Collection 
     */
    public function getUTR3s() {
        return $this->UTR3s;
    }
    
    /**
     * Add UTR3
     * 
     * @param UTR3 $UTR3 
     * @param boolean $recurse 
     */
    public function addUTR3(UTR3 $UTR3,$recurse = true) {
        $this->UTR3s[] = $UTR3;
        if ($recurse === true) {
            $UTR3->addmRNA($this, false);
        }
    }
        
    /**
     * Remove UTR3
     * 
     * @param UTR3 $UTR3 
     * @param boolean $recurse 
     */
    public function removeUTR3(UTR3 $UTR3,$recurse = true) {
        $this->UTR3s->removeElement($UTR3);
        if ($recurse === true) {
            $UTR3->removemRNA($this, false);
        }
    }
    
    /**
     * Get gene
     * 
     * @return Gene
     * @return false if mRNA is polycistronic 
     */
    public function getGene() {
        if ($this->genes->count() == 1) {
            return $this->genes->first();
        } else if ($this->genes->count() > 1) {
            return false;
        } else {
            return NULL;
        }
    }
    
    /**
     * Set gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function setGene(Gene $gene,$recurse = true) {
        if ($this->genes->count() > 0) {
            foreach ($this->genes as $remgene) {
                $this->removeGene($remgene,$recurse);
            }
        }
        $this->addGene($gene,$recurse);
    }
    
    /**
     * Get genes
     * 
     * @return Collection 
     */
    public function getGenes() {
        return $this->genes;
    }
    
    /**
     * Add gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function addGene(Gene $gene,$recurse = true) {
        $this->genes[] = $gene;
        if ($recurse === true) {
            $gene->addmRNA($this, false);
        }
    }
        
    /**
     * Remove gene
     * 
     * @param Gene $gene 
     * @param boolean $recurse 
     */
    public function removeGene(Gene $gene,$recurse = true) {
        $this->genes->removeElement($gene);
        if ($recurse === true) {
            $gene->removemRNA($this, false);
        }
    }
    
    /**
     * Get parents
     * 
     * @return Collection  
     */
    public function getParents() {
        $parents = parent::getParents();
        foreach ($this->genes as $gene) {
            if (!$parents->contains($gene)) {
                $parents->add($gene);
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
        if ($parent instanceof Gene) {
            $this->addGene($parent,$recurse);
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
        if ($parent instanceof Gene) {
            $this->removeGene($parent,$recurse);
        } else {
            parent::removeParent($parent, $recurse);
        }
    }
    
    /**
     * Get children
     * 
     * @return Collection 
     */
    public function getChildren() {
        $children = parent::getChildren();
        foreach ($this->CDSs as $CDS) {
            if (!$children->contains($CDS)) {
                $children->add($CDS);
            }
        }
        foreach ($this->UTR5s as $UTR5) {
            if (!$children->contains($UTR5)) {
                $children->add($UTR5);
            }
        }
        foreach ($this->UTR3s as $UTR3) {
            if (!$children->contains($UTR3)) {
                $children->add($UTR3);
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
        if($child instanceof CDS) {
            $this->addCDS($child,$recurse);
        } else if ($child instanceof UTR5) {
            $this->addUTR5($child,$recurse);
        } else if ($child instanceof UTR3) {
            $this->addUTR3($child,$recurse);
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
        if($child instanceof CDS) {
            $this->removeCDS($child,$recurse);
        } else if ($child instanceof UTR5) {
            $this->removeUTR5($child,$recurse);
        } else if ($child instanceof UTR3) {
            $this->removeUTR3($child,$recurse);
        } else {
            parent::removeChild($child, $recurse);
        }
    }
       
    /**
     * Is polycistronic
     * 
     * @return boolean 
     */
    public function isPolycistronic() {
        return ($this->genes->count() > 1) ? true : false;
    }
}

?>