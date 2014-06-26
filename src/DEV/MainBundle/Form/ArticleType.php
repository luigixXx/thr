<?php

namespace DEV\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text', array(
								        'attr' => array(
								         'class' => 'controls'),'label'=>"Titre"
								    ))
			->add('categorie', 'entity', array('class' => 'DEVMainBundle:Categorie', 
            							  'property' => 'nom', 'empty_value' => "Catégorie de l'article", 
            							  'label' => "Catégorie de l'article"))
            ->add('content', 'textarea', array(
								        'attr' => array(
								         'class' => 'tinymce form_control', 'data-theme'=>'advanced'),'label'=>"Contenu"
								    ))
            ->add('enable', 'checkbox', array(
								        'attr' => array(
								         'class' => 'form_control'),'label'=>"Publier",'required'    => false
								    ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DEV\MainBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dev_mainbundle_article';
    }
}
