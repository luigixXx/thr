<?php

namespace DEV\ChefBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChefController extends Controller
{
    public function indexAction()
    {
        return $this->render('DEVChefBundle:Chef:index.html.twig');
    }
}
