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

use VIB\Bundle\BioFormatsBundle\FileFormat\FastAFile;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name = "guest")
    {
        $fasta_in = new FastAFile(new \SplFileObject("/tmp/test.fasta"));
        //$fasta_out = new FastAFile(new \SplFileObject("/tmp/test-output.fasta","w+"));
        
        echo "<pre>";
        
        foreach ($fasta_in->getSequences() as $sequence) {
            echo "Processing " . $sequence->getName() . "\n";
            //$fasta_out->addSequence($sequence);
        }
        
        echo "</pre>";
        
        //$fasta_out->save();
    }
}
