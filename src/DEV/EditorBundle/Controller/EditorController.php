<?php

namespace DEV\EditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DEV\MainBundle\Entity\Actu;
use DEV\MainBundle\Form\ActuType;

class EditorController extends Controller {
	public function indexAction() {
		return $this -> render('DEVEditorBundle:Editor:index.html.twig');
	}

	public function addActuAction($id) {
		if ($id == 0) {
			$actu = new Actu;
			$flash = 'Actualité ajoutée!!';
		} else {
			//récupération de l'actu à traiter
			$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
			$actu = $repository -> find($id);
			$flash = 'Actualité modifée!!';
		}
		$form = $this -> createForm(new ActuType, $actu);

		$request = $this -> get('request');
		if ($request -> getMethod() == 'POST') {
			$form -> bind($request);
			$actu->setDatemod(new \DateTime('now'));
			if ($form -> isValid()) {
				$em = $this -> getDoctrine() -> getManager();
				$em -> persist($actu);
				$em -> flush();
				$this -> get('session') -> getFlashBag() -> add('notice', $flash);
				return $this -> redirect($this -> generateUrl('dev_editor_list_news'));
			}
		}

		return $this -> render('DEVEditorBundle:Editor:newActu.html.twig', array('form' => $form -> createView(), ));
	}

	public function listActuAction() {
		//récupération des actus
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');

		$actus = $repository -> findAll();
		return $this -> render('DEVEditorBundle:Editor:listActu.html.twig', array('actus' => $actus));
	}
	
	public function delActuAction($id){
		//récupération de l'actu à traiter
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');
		$actu = $repository -> find($id);
		//suppression de l'actu
		$em = $this -> getDoctrine() -> getManager();
				$em -> remove($actu);
				$em -> flush();
		//ajout du flashbag et redirection
		$this -> get('session') -> getFlashBag() -> add('notice', 'Actualité supprimée!!');
				return $this -> redirect($this -> generateUrl('dev_editor_list_news'));
		
	}

}
