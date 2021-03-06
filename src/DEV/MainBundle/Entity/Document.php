<?php

namespace DEV\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Document
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DEV\MainBundle\Entity\DocumentRepository")
 */
class Document {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

	/**
	 * @Assert\File(maxSize="6000000")
	 */
	public $file;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	public $path;

	public function getAbsolutePath() {
		return null === $this -> path ? null : $this -> getUploadRootDir() . '/' . $this -> path;
	}

	public function getWebPath() {
		return null === $this -> path ? null : $this -> getUploadDir() . '/' . $this -> path;
	}

	protected function getUploadRootDir() {
		// le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
		return __DIR__ . '/../../../../web/' . $this -> getUploadDir();
	}

	protected function getUploadDir() {
		// on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
		// le document/image dans la vue.
		return 'uploads/documents';
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload() {
		if (null !== $this -> file) {
			// faites ce que vous voulez pour générer un nom unique
				$this -> path = sha1(uniqid(mt_rand(), true)) . '.' . $this -> file -> getClientOriginalExtension();
			
		}
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload() {
		if (null === $this -> file) {
			return;
		}

		// s'il y a une erreur lors du déplacement du fichier, une exception
		// va automatiquement être lancée par la méthode move(). Cela va empêcher
		// proprement l'entité d'être persistée dans la base de données si
		// erreur il y a
		$this -> file -> move($this -> getUploadRootDir(), $this -> path);

		unset($this -> file);
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload() {
		if ($file = $this -> getAbsolutePath()) {
			unlink($file);
		}
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this -> id;
	}

	/**
	 * Set path
	 *
	 * @param string $path
	 * @return Document
	 */
	public function setPath($path) {
		$this -> path = $path;

		return $this;
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath() {
		return $this -> path;
	}


    /**
     * Set nom
     *
     * @param string $nom
     * @return Document
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
}
