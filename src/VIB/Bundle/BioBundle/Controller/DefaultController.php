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
        $fastA = new FastAFile(new \SplFileObject("/tmp/example.fas"));
        if ($fastA->isValid()) {
            $sequences = $fastA->getSequences();
            $fastA = new FastAFile(new \SplFileObject("/tmp/example_output.fas","w"),$sequences);
            $fastA->writeFile();
            return array('sequences' => $sequences, 'correct' => true);
        } else {
            return array('correct' => false);
        }
        
    }
}
