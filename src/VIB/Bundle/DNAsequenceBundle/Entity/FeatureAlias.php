<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\FeatureAlias
 *
 * @ORM\Table(name="DNAfeatureAlias", indexes={
 *      @ORM\Index(name="alias_idx", columns={"alias"})
 * })
 * 
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\FeatureAliasRepository")
 */
class FeatureAlias extends AbstractEntity\FeatureAlias
{
    /**
     * @var Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
