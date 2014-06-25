<?php

namespace DEV\EditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DEV\MainBundle\Entity\Actu;
use DEV\MainBundle\Form\ActuType;

class EditorController extends Controller {
	public function indexAction() {
		return $this -> render('DEVEditorBundle:Editor:index.html.twig');
	}

	public function addActuAction() {
		$actu = new Actu;
		$form = $this -> createForm(new ActuType, $actu);

		$request = $this -> get('request');
		if ($request -> getMethod() == 'POST') {
			$form -> bind($request);

			if ($form -> isValid()) {
				$em = $this -> getDoctrine() -> getManager();
				$em -> persist($actu);
				$em -> flush();

				return $this -> redirect($this -> generateUrl('dev_editor_homepage'));
			}
		}

		return $this -> render('DEVEditorBundle:Editor:newActu.html.twig', array('form' => $form -> createView(), ));
	}

}
