<?php

namespace DEV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DEV\MainBundle\Entity\Actu;

class MainController extends Controller {
	public function indexAction() {
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
		$actus = $repository -> findBy(array('enable' => '1'),
                                     array('datemod' => 'desc'));
		return $this -> render('DEVMainBundle:Main:index.html.twig', array('actus'=>$actus));
	}

	public function scoutismeAction() {
		return $this -> render('DEVMainBundle:Main:scoutisme.html.twig');
	}
	
	public function displayActuAction($id){
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
		$actu = $repository -> find($id);
		return $this -> render('DEVMainBundle:Main:actu.html.twig', array('actu'=>$actu));
	}

}
