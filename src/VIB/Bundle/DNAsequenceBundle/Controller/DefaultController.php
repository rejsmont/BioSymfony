<?php

namespace VIB\Bundle\DNAsequenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use VIB\Bundle\DNAsequenceBundle\Entity\Gene;
use VIB\Bundle\DNAsequenceBundle\Entity\Sequence;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name = "guest")
    {
        $seq = new Sequence();
        $gene = new Gene();
        
        $seq->setName("a sequence");
        $gene->setName("a gene");
        $gene->setSequence($seq);
        
        return array('gene' => $gene);
    }
}
