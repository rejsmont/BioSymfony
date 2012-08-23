<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\mRNA
 * 
 * @ORM\Entity
 */
class mRNA extends Feature {

    /**
     * @var Collection $genes
     * 
     * @ORM\ManyToMany(targetEntity="Gene", mappedBy="mRNAs")
     */
    protected $genes;
}

?>