<?php

namespace DEV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DEV\MainBundle\Entity\Actu;
use DEV\MainBundle\Entity\Article;
use DEV\MainBundle\Entity\Categorie;

class MainController extends Controller {
	public function indexAction() {
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
		$actus = $repository -> findBy(array('enable' => '1'),
                                     array('datemod' => 'desc'));
		return $this -> render('DEVMainBundle:Main:index.html.twig', array('actus'=>$actus));
	}

	public function scoutismeAction() {		
		//récupération des articles
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
		$articles = $repository ->findBy(array('enable' => '1'),
                                     array('datemod' => 'desc'));
		return $this -> render('DEVMainBundle:Main:scoutisme.html.twig', array('articles'=>$articles));
	}
	
	public function groupeAction() {		
		//récupération des articles
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
		$articles = $repository ->findBy(array('enable' => '1'),
                                     array('datemod' => 'desc'));
		return $this -> render('DEVMainBundle:Main:groupe.html.twig', array('articles'=>$articles));
	}

	public function techniqueAction() {		
		//récupération des articles
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
		$articles = $repository ->findBy(array('enable' => '1'),
                                     array('datemod' => 'desc'));
		return $this -> render('DEVMainBundle:Main:technique.html.twig', array('articles'=>$articles));
	}
	
	public function displayActuAction($id){
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
		$actu = $repository -> find($id);
		return $this -> render('DEVMainBundle:Main:actu.html.twig', array('actu'=>$actu));
	}

	public function displayArticleAction($id){
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
		$actu = $repository -> find($id);
		return $this -> render('DEVMainBundle:Main:actu.html.twig', array('actu'=>$actu));
	}

}
