<?php

namespace DEV\EditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DEV\MainBundle\Entity\Actu;
use DEV\MainBundle\Form\ActuType;
use DEV\MainBundle\Entity\Article;
use DEV\MainBundle\Form\ArticleType;
use DEV\MainBundle\Entity\Document;
use DEV\MainBundle\Form\DocumentType;

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
	
	public function addArticleAction($id) {
		if ($id == 0) {
			$article = new Article;
			$flash = 'Article ajouté!!';
		} else {
			//récupération de l'article à traiter
			$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
			$article = $repository -> find($id);
			$flash = 'Article modifé!!';
		}
		$form = $this -> createForm(new ArticleType, $article);

		$request = $this -> get('request');
		if ($request -> getMethod() == 'POST') {
			$form -> bind($request);
			$article->setDatemod(new \DateTime('now'));
			$usr = $this->get('security.context')->getToken()->getUser();
			$article->setAuteur($usr);
			if ($form -> isValid()) {
				$em = $this -> getDoctrine() -> getManager();
				$em -> persist($article);
				$em -> flush();
				$this -> get('session') -> getFlashBag() -> add('notice', $flash);
				return $this -> redirect($this -> generateUrl('dev_editor_list_articles'));
			}
		}

		return $this -> render('DEVEditorBundle:Editor:newArticle.html.twig', array('form' => $form -> createView(), ));
	}

	public function listActuAction() {
		//récupération des actus
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Actu');

		$actus = $repository -> findAll();
		return $this -> render('DEVEditorBundle:Editor:listActu.html.twig', array('actus' => $actus));
	}
	
	public function listArticleAction() {
		//récupération des articles
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');

		$articles = $repository -> findAll();
		return $this -> render('DEVEditorBundle:Editor:listArticle.html.twig', array('articles' => $articles));
	}
	
	public function listDocAction() {
		//récupération des articles
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Document');

		$docs = $repository -> findAll();
		return $this -> render('DEVEditorBundle:Editor:listDocument.html.twig', array('docs' => $docs));
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

		public function delArticleAction($id){
		//récupération de l'article à traiter
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Article');
		$article = $repository -> find($id);
		//suppression de l'actu
		$em = $this -> getDoctrine() -> getManager();
				$em -> remove($article);
				$em -> flush();
		//ajout du flashbag et redirection
		$this -> get('session') -> getFlashBag() -> add('notice', 'Article supprimé!!');
				return $this -> redirect($this -> generateUrl('dev_editor_list_articles'));
		
	}
		
		public function uploadDocAction(){
		$document = new Document();
		$form = $this -> createForm(new DocumentType, $document);
		if ($this -> getRequest() -> isMethod('POST')) {
			$form -> bind($this -> getRequest());
			if ($form -> isValid()) {
					$em = $this -> getDoctrine() -> getManager();
					$em -> persist($document);
					$em -> flush();
				$this -> get('session') -> getFlashBag() -> add('notice', 'Mise en ligne effectuée avec succès, vous pouvez fermer la  fenêtre.');
				
			}
			$this -> redirect($this -> generateUrl("dev_editor_list_doc"));
		}
		return $this -> render('DEVEditorBundle:Editor:newDoc.html.twig', array('form' => $form -> createView()));
		}

		public function delDocAction($id){
		//récupération du document à traiter
		$repository = $this -> getDoctrine() -> getManager() -> getRepository('DEVMainBundle:Document');
		$doc = $repository -> find($id);
		//suppression du doc
		$em = $this -> getDoctrine() -> getManager();
				$em -> remove($doc);
				$em -> flush();
		//ajout du flashbag et redirection
		$this -> get('session') -> getFlashBag() -> add('notice', 'Document supprimée!!');
				return $this -> redirect($this -> generateUrl('dev_editor_list_doc'));
		
	}
}
