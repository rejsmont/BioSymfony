<?php

/*
 * This file is part of the BioSymfony framework.
 *
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace VIB\Bundle\BioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use VIB\Bundle\BioBundle\Entity\DNA\Feature\Gene\CDS;
use VIB\Bundle\BioBundle\Entity\DNA\Sequence;

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
        $CDS = new CDS();
        
        $seq->setName("a sequence");
        $CDS->setName("a gene");
        $CDS->setSequence($seq);
        
        return array('gene' => $gene);
    }
}
