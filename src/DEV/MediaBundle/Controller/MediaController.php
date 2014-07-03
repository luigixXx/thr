<?php

namespace DEV\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaController extends Controller {
	public function indexAction() {

		$params = array(
		'api_key' => '38b32caa201be574b1c8349c17a77db7',
		'method' => 'flickr.photosets.getList', 
		'user_id' => '125759822@N05', 
		'format' => 'php_serial', 
		'primary_photo_extras' => '');

		$encoded_params = array();

		foreach ($params as $k => $v) {

			$encoded_params[] = urlencode($k) . '=' . urlencode($v);
		}

		#
		# appeler l'API et décoder la réponse
		#

		$url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);

		$rsp = file_get_contents($url);

		$rsp_obj = unserialize($rsp);
		return $this -> render('DEVMediaBundle:Media:index.html.twig', array('data' => $rsp_obj));
	}

	public function getPhotosAlbumAction($id) {
		$params = array(
		'api_key' => '38b32caa201be574b1c8349c17a77db7', 
		'method' => 'flickr.photosets.getPhotos',
		'photoset_id'=>$id,
		'user_id' => '125759822@N05', 
		'format' => 'php_serial', 
		'primary_photo_extras' => '');

		$encoded_params = array();

		foreach ($params as $k => $v) {

			$encoded_params[] = urlencode($k) . '=' . urlencode($v);
		}

		#
		# appeler l'API et décoder la réponse
		#

		$url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);

		$rsp = file_get_contents($url);

		$rsp_obj = unserialize($rsp);
		return $this -> render('DEVMediaBundle:Media:album.html.twig', array('data' => $rsp_obj));
	}

}
