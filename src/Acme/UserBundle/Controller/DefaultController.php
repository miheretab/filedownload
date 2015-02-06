<?php

namespace Acme\UserBundle\Controller;

use Acme\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	
    public function indexAction()
    {
        return $this->render('AcmeUserBundle:Default:index.html.twig', array('user' => $this->getUser()));
    }
	
    public function registerAction(Request $request)
    {
		
		$user = new User();
		$form = $this->createFormBuilder($user)
			->add('email', 'email')
			->add('username', 'text')
			->add('password', 'password')
			->add('register', 'submit', array('label' => 'Register'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {

			$em = $this->getDoctrine()->getManager();
			
			$encoder = $this->container->get('security.password_encoder');
			$encoded = $encoder->encodePassword($user, $user->getPassword());

			$user->setPassword($encoded);

			$em->persist($user);
			$em->flush();

			$request->getSession()->getFlashBag()->add(
				'notice',
				'You are registered!'
			);			

			return $this->redirect($this->generateUrl('login'));
		}			

        return $this->render('AcmeUserBundle:Default:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }	
	
}
