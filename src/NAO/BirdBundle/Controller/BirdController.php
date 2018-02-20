<?php

namespace NAO\BirdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Validator
use Symfony\Component\Validator\Validator\ValidatorInterface;

// Entity
use NAO\BirdBundle\Entity\User;
use NAO\BirdBundle\Entity\Observation;
use NAO\CoreBundle\Entity\Message;
use NAO\BirdBundle\Entity\Aves;
use NAO\CoreBundle\Entity\Newsletter;

// Form Type
use NAO\BirdBundle\Form\Type\UserType;
use NAO\BirdBundle\Form\Type\ObservationType;

// Component HttpFoundation
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BirdController extends Controller
{
	// Login and register
	public function loginAction(Request $request)
	{
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirectToRoute('nao_bird_new_obs');
		}

		// Formulaire
		$user = new User;

		$userType = $this->get('form.factory')->create(UserType::class, $user);

		// Traitement des données 
		$userType->handleRequest($request);

		if ($userType->isSubmitted() && $userType->isValid())
		{
			extract($request->get('nao_birdbundle_user'));

			// Cryptage du mot de passe
			$encoder = $this->container->get('security.password_encoder');

			$encoded = $encoder->encodePassword($user, $password);

			$user->setPassword($encoded);

			// Enregistrement de l'utilisateur en base de données
			$em = $this->getDoctrine()->getManager();

			$em->persist($user);

			$em->flush();

			// Message flash
			$this->addFlash('success', 'Vous êtes bien inscrit. Vous pouvez maintenant vous connectez.');
		}

		$authUtils = $this->get('security.authentication_utils');

		return $this->render('NAOBirdBundle:Bird:login.html.twig', array(
		    'last_username' => $authUtils->getLastUsername(),
		    'error' => $authUtils->getLastAuthenticationError(),
		    'userType' => $userType->createView()
		            )
		        );
	}

	// Bird map
	public function birdMapAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$observations = $em->getRepository(Observation::class)->findByValidated(true);

		$obsQuantity = count($observations);
		
		if ($request->isMethod('POST') != null && $request->get('species') != null)
		{
			$observations = $em->getRepository(Observation::class)->getSpeciesValidated(htmlspecialchars($request->get('species')));
		}

		return $this->render('NAOBirdBundle:Bird:birdMap.html.twig', array(
			'observations' => $observations,
			'obsQuantity' => $obsQuantity
			)
		);

	}

	// New observation
	public function newObsAction(Request $request)
	{
		// Formulaire Observation
		$observation = new Observation();
		
		$em = $this->getDoctrine()->getManager();

		/*
		* Si des infos sont envoyés on cherche des informations dans la base de donnée Aves
		* et on hydrate l'obejet Observayion
		*/  
		if ($request->isMethod('POST') != NULL)
		{
			$bird = $em->getRepository(Aves::class)->find((int) $request->get('birdname'));

			if (!$bird)
			{
				$this->addFlash('danger', 'Vous devez choisir le nom d\'un oiseau.');

				return $this->redirectToRoute('nao_bird_new_obs');
			}

			$observation->setBirdname(ucfirst(strtolower($bird->getNomVern())));

			$observation->setSpecies(ucfirst(strtolower($bird->getFamille())));	
		}

		$observationType = $this->get('form.factory')->create(ObservationType::class, $observation);

		// Traitement des données 
		$observationType->handleRequest($request);

		if ($observationType->isSubmitted() && $observationType->isValid())
		{
			$checkForm = $this->get('nao_bird.checkForm');

			// Recupération de l'utilisateur
			$user = $this->get('security.token_storage')->getToken()->getUser();

			// Si l'utilisateur est un naturaliste
			if ($user->getRoles()[0] === 'ROLE_NAT')
			{
				$observation->setValidated(true);
			}

			$observation->getPhoto()->setAlt(ucfirst(strtolower($bird->getNomVern())));

			$observation->setUser($user);

			$errorUpload = $observation->getPhoto()->upload();

			if (!empty($errorUpload))
			{
				if ($errorUpload === 'error_file')
				{
					$this->addFlash('danger', 'Vous devez choisir un fichier.');
				}
				elseif ($errorUpload === 'error_extension')
				{
					$this->addFlash('danger', 'Votre fichier doit être un jpg ou un jpeg.');
				}
				elseif ($errorUpload === 'error_size')
				{
					$this->addFlash('danger', 'Votre fichier est trop lourd.');
				}

				return $this->redirectToRoute('nao_bird_new_obs');
			}

			// Enregistrement de l'observation en base de donnée
			$em->persist($observation);

			$em->flush();

			$this->addFlash('notice', 'Nouvelle observation envoyée !');

			// return $this->redirectToRoute('nao_bird_new_obs');
		}

		$avesBirds = $em->getRepository(Aves::class)->getNomVernAndFamille();

		return $this->render('NAOBirdBundle:Bird:newObs.html.twig', array(
			'observationType' => $observationType ->createView(),
			'avesBirds' => $avesBirds
			)
		);
	}

	// Admin
	public function adminAction()
	{
		// Récupération des observation et des utilisateurs
		$em = $this->getDoctrine()->getManager();

		$observations = $em->getRepository(Observation::class)->findAll();

		$users = $em->getRepository(User::class)->findAll();

		$messages = $em->getRepository(Message::class)->findAll();

		$newsletters = $em->getRepository(Newsletter::class)->findAll();

		// Création de token de sécurité
		$obsToken = password_hash($this->getParameter('edit_obs_token'), PASSWORD_DEFAULT);

		$userToken = password_hash($this->getParameter('edit_user_token'), PASSWORD_DEFAULT);

		$messageToken = password_hash($this->getParameter('edit_message_token'), PASSWORD_DEFAULT);

		return $this->render('NAOBirdBundle:Bird:admin.html.twig', 
			array('observations' => $observations,
				'obsToken' => $obsToken,
				'users' => $users,
				'userToken' => $userToken,
				'messages' => $messages,
				'newsletters' => $newsletters,
				'messageToken' => $messageToken
				)
			);
	}

	// Homepage
	public function homepageAction()
	{
		// Récupération des données de sessions utilisateurs
		$user = $this->get('security.token_storage')->getToken()->getUser();

		// Récupération des obersations de l'utilisateur
		$em = $this->getDoctrine()->getManager();

		$observations = $em->getRepository(Observation::class)->findByUser($user->getId());

		return $this->render('NAOBirdBundle:Bird:homepage.html.twig', array('observations' => $observations));
	}

	// Edit Observation
	public function editObsAction(Request $request)
	{
		// Traitement des données 
		if ($request->isMethod('POST') !== null)
		{
			// Vérification du token, du referer et de l'id
			$checkForm = $this->get('nao_bird.checkForm');

			$error = $checkForm->scan(
				array('saveToken' => $this->getParameter('edit_obs_token'), 'sentToken' => $request->get('obsToken')),
				array('saveReferer' => $this->getParameter('referer_edit_obs'), 'sentReferer' => $request->server->get('HTTP_REFERER')),
				$request->get('obsId')
			);

			if (count($error) > 0)
			{
				return $this->redirectToRoute('nao_bird_admin');
			} 

			if (!in_array($request->get('validated'), array('true', 'false')))
			{
				return $this->redirectToRoute('nao_bird_admin');
			}

			$em = $this->getDoctrine()->getManager();
			
			$observation = $em->getRepository(Observation::class)->find((int) $request->get('obsId'));

			// Vérification d'observation
			if (!$observation)
			{
				return $this->redirectToRoute('nao_bird_admin');
			}

			// Vadification du champ "Validated"
			if ($request->get('validated') === 'true')
			{
				$observation->setValidated(true);

				$this->addFlash('success', 'L\'observation a bien été publié.');
			}
			else
			{
				$this->addFlash('success', 'L\'observation a bien été masqué.');

				$observation->setValidated(0);
			}

			$em->persist($observation);

			$em->flush();

			return $this->redirectToRoute('nao_bird_admin');
		}
	}

	// Edit User
	public function editUserAction(Request $request)
	{
		if ($request->isMethod('POST') !== null)
		{
			// Vérification du token, referer, id
			$checkForm = $this->get('nao_bird.checkForm');

			$error = $checkForm->scan(
				array('saveToken' => $this->getParameter('edit_user_token'), 'sentToken' => $request->get('userToken')),
				array('saveReferer' => $this->getParameter('referer_edit_obs'), 'sentReferer' => $request->server->get('HTTP_REFERER')),
				$request->get('obsId')
			);

			if (!in_array($request->get('roles'), array('ROLE_NAT', 'ROLE_USER')))
			{
				return $this->redirectToRoute('nao_bird_admin');
			}

			// Récupération et vérification de l'utilisateur
			$em = $this->getDoctrine()->getManager();
			
			$user = $em->getRepository(User::class)->find((int) $request->get('userId'));

			if (!$user)
			{
				return $this->redirectToRoute('nao_bird_admin');
			}

			// Si l'utilisateur a déjà ce role
			if ($user->getRoles()[0] === $request->get('roles'))
			{
				$this->addFlash('success', 'Vous possedez déjà ce rôle.');

				return $this->redirectToRoute('nao_bird_admin');
			}

			/**
			* Récupération des observations de l'utlisateur pour modifier leurs status
			* Si l'utilisateur devient naturaliste on publie toutes ses observations
			*/
			$observations = $em->getRepository(Observation::class)->findByUser($user);

			// Modification du champs "roles"
			if ($request->get('roles') === 'ROLE_NAT')
			{
				$user->setRoles($request->get('roles'));

				// Modification du status des observations
				foreach ($observations as $obs)
				{
					$obs->setValidated(true);

					$em->persist($obs);
				}

				$this->addFlash('success', 'L\'utilisateur a bien été modifié en naturaliste.');
			}
			else
			{

				$user->setRoles($request->get('roles'));

				// Modification du status des observations
				foreach ($observations as $obs)
				{
					$obs->setValidated(0);

					$em->persist($obs);
				}

				$this->addFlash('success', 'Le naturaliste a bien été modifié en utilisateur.');
			}

			$em->persist($user);	
			
			$em->flush();

			return $this->redirectToRoute('nao_bird_admin');
		}
	}

	// Edit Message
	public function editMessageAction(Request $request)
	{
		if ($request->isMethod('POST') !== null)
		{
			// Vérification du token, referer, id
			$checkForm = $this->get('nao_bird.checkForm');

			$error = $checkForm->scan(
				array('saveToken' => $this->getParameter('edit_message_token'), 'sentToken' => $request->get('messageToken')),
				array('saveReferer' => $this->getParameter('referer_edit_obs'), 'sentReferer' => $request->server->get('HTTP_REFERER')),
				$request->get('msgId')
			);

			// Récupération de l'utilisateur
			$user = $this->get('security.token_storage')->getToken()->getUser();

			$em = $this->getDoctrine()->getManager();
			
			$message = $em->getRepository(Message::class)->find($request->get('msgId'));

			if ($request->get('msgRead') === 'true') // Le message a été lus
			{
				$message->setMsgRead(true);	

				$this->addFlash('success', 'Le message a bien été marqué comme lus.');
			}
			elseif ($request->get('msgRead') === 'false') // Le message a été marquer comme non lus
			{
				$message->setMsgRead(false);

				$this->addFlash('success', 'Le message a bien été marqué comme non lus.');
			}
			else // Mauvaise info
			{
				return $this->redirectToRoute('nao_bird_admin');
			}

			$em->persist($message);	
			
			$em->flush();

			// return new Response('<pre>' . print_r($message, true) . '</pre>');

			return $this->redirectToRoute('nao_bird_admin');
		}
	}

	// Page pour la requête ajax Search Bird
	public function resultsSearchBirdsAction(Request $request)
	{
		// Si les informations sont envoyés
		if ($request->isMethod('POST') != null && $request->get('value') != null)
		{
			$em = $this->getDoctrine()->getManager();

			// Recherche par espèce
			$allSpecies = $em->getRepository(Observation::class)->getListBySpecies($request->get('value'));

			if (!$allSpecies) // Si la recherche ne donne rien 
			{
				// Recherche par nom d'oiseau
				$allBirdnames = $em->getRepository(Observation::class)->getListByBirdname($request->get('value'));
			}
			else // S'il y a des résutats
			{
				$allBirdnames = null;
			}
		}
		else
		{
			$allSpecies = null;	
			$allBirdnames = null;	
		}

		return $this->render('NAOBirdBundle:Bird:resultsSearchBirds.html.twig', array(
			'allSpecies' => $allSpecies,
			'allBirdnames' => $allBirdnames
			)
		);
	}
}
