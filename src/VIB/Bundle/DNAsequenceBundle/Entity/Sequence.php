<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Sequence
 *
 * @ORM\Table(name="DNAsequence")
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\SequenceRepository")
 */
class Sequence extends AbstractEntity\Sequence
{
    /**
     * @var Collection $features
     * 
     * @ORM\OneToMany(targetEntity="Feature", mappedBy="sequence")
     */
    protected $features;
    
}
