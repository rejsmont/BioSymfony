<?php

namespace VIB\Bundle\DNAsequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VIB\Bundle\DNAsequenceBundle\Entity\Location
 *
 * @ORM\Table(name="DNAlocation")
 * @ORM\Entity(repositoryClass="VIB\Bundle\DNAsequenceBundle\Entity\LocationRepository")
 */
class Location
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $version
     * 
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     */
    protected $version;

    /**
     * @var string $start
     * 
     * @ORM\Column(name="start", type="integer")
     */
    protected $start;
    
    /**
     * @var string $end
     * 
     * @ORM\Column(name="end", type="integer")
     */
    protected $end;
    
    /**
     * @var string $strand
     * 
     * @ORM\Column(name="strand", type="string", length=1)
     */
    protected $strand;

    /**
     * @var Feature $feature
     * 
     * @ORM\ManyToOne(targetEntity="Feature", inversedBy="aliases")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     */
    protected $feature;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
