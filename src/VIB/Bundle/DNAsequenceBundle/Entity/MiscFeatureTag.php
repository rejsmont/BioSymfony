<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use VIB\Bundle\DNAsequenceBundle\AbstractEntity as AbstractEntity;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\FeatureTag
 *
 * @ORM\Table(name="DNAmiscFeatureTag", indexes={
 *      @ORM\Index(name="field_idx", columns={"field"}),
 *      @ORM\Index(name="value_idx", columns={"value"}),
 *      @ORM\Index(name="field_value_idx", columns={"field","value"})
 * })
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Repository\FeatureTagRepository")
 */
class MiscFeatureTag extends AbstractEntity\FeatureTag
{
    /**
     * @var MiscFeature $feature
     * 
     * @ORM\ManyToOne(targetEntity="MiscFeature", inversedBy="tags")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
}
