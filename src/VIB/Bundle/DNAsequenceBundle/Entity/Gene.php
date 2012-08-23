<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}

?>