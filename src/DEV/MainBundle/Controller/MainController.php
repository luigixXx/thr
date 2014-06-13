<?php

namespace DEV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('DEVMainBundle:Main:index.html.twig');
    }
	
	 public function scoutismeAction()
    {
        return $this->render('DEVMainBundle:Main:index.html.twig');
    }
}
