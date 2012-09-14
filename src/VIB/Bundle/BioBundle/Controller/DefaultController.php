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

use VIB\Bundle\BioFormatsBundle\FileFormat\GFFFile;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name = "guest")
    {
        $GFF = new GFFFile(new \SplFileObject("/tmp/dmel-all-r5.46.gff"));
        $GFF->indexFile();
        
        $sequenceNo = count($GFF->sequenceIndex);
        $featureNo = 0;
        foreach ($GFF->featureIndex as $sequenceFeatures) {
            $featureNo += count($sequenceFeatures);
        }        
        return array('sequenceNo' => $sequenceNo,'featureNo' => $featureNo);

        //if ($fastA->isValid()) {
        //    $sequences = $fastA->getSequences();
        //    $fastA = new FastAFile(new \SplFileObject("/tmp/example_output.fas","w"),$sequences);
        //    $fastA->writeFile();
        //    return array('sequences' => $sequences, 'correct' => true);
        //} else {
        //    return array('correct' => false);
        //}
        
    }
}
