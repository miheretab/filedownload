<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DocumentsController extends Controller
{
    /**
     * @Route("/", name="documents")
	 * #@Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
	
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT f
			FROM AppBundle:Document f
			ORDER BY f.name ASC'
		);

		$documents = $query->getResult();
        return $this->render('documents/index.html.twig', array('documents' => $documents));
    }

    /**
     * @Route("/add", name="documents_add")
     */
	public function addAction(Request $request)
	{
	
		$document = new Document();
		$form = $this->createFormBuilder($document)
			->add('name', 'text', array('attr' => array("ng-model" => "name")))
			->add('file', 'file', array('attr' => array("fileread" => "file")))
			->add('save', 'submit', array('label' => 'Submit'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			 
			$em->persist($document);
			$em->flush();

			$request->getSession()->getFlashBag()->add(
				'notice',
				'Your documents were added!'
			);			

			return $this->redirect($this->generateUrl('documents'));
		}			

        return $this->render('documents/add.html.twig', array(
            'form' => $form->createView(),
        ));
		
	}
	
    /**
     * @Route("/view/{id}", name="documents_view")
     */	
	public function viewAction($id)
	{
		$document = $this->getDoctrine()
			->getRepository('AppBundle:Document')
			->find($id);

		if (!$document) {
			throw $this->createNotFoundException(
				'No document found for id '.$id
			);
		}

		return $this->render('documents/view.html.twig', array('document' => $document));
	}	
}
