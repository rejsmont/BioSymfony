<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Location
 *
 * @ORM\Table(name="DNAmiscLocation")
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\LocationRepository")
 */
class MiscLocation extends AbstractEntity\Location
{
    /**
     * @var MiscFeature $feature
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
