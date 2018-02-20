<?php

namespace NAO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use NAO\CoreBundle\Entity\Message;
use NAO\BirdBundle\Entity\User;
use NAO\CoreBundle\Entity\Newsletter;

use NAO\CoreBundle\Form\Type\MessageType;
use NAO\CoreBundle\Form\Type\NewsletterType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
	// Home
	public function homeAction(Request $request)
	{
		//Créeation du formulaire
		$newsletter = new Newsletter;

		$newsletterType = $this->get('form.factory')->create(NewsletterType::class, $newsletter);

		// Récupération et traitement des données
		$newsletterType->handleRequest($request);

		if ($newsletterType->isSubmitted() && $newsletterType->isValid())
		{
			// Enregistrement de l'adresse mail
			$em = $this->getDoctrine()->getManager();

			$em->persist($newsletter);

			$em->flush();

			// Message de succès
			$this->addFlash('success', 'Vous êtes inscrit à la Newsletter.');

			// Redirection
			return $this->redirectToRoute('nao_core_home');
		}

		return $this->render('NAOCoreBundle:Core:home.html.twig',
			array('newsletterType' => $newsletterType->createView())
		);
	}

	// About
	public function aboutAction()
	{
		return $this->render('NAOCoreBundle:Core:about.html.twig');
	}

	// Contact
	public function contactAction(Request $request)
	{
		// Création du formulaire
		$message = new Message;

		$messageType = $this->get('form.factory')->create(MessageType::class, $message);

		// Récupération et traitement des données
		$messageType->handleRequest($request);

		if ($messageType->isSubmitted() && $messageType->isValid())
		{
			// 1. Enregistrement des données
			$em = $this->getDoctrine()->getManager();

			$em->persist($message);

			$em->flush();

			// 2. Message de succes
			$this->addFlash('success', 'Message envoyé !');

			// 3. Redirection
			return $this->redirectToRoute('nao_core_contact');
		}

		return $this->render('NAOCoreBundle:Core:contact.html.twig', array('messageType' => $messageType->createView()));
	}
}
