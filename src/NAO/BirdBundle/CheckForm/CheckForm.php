<?php

namespace NAO\BirdBundle\CheckForm;

class CheckForm
{
	/*
	* Cette méthode permet de vérfié des informations
	* en lien avec des formulaires
	*/
	public function scan(Array$token, Array $referer, $id)
	{
		// Tableau d'erreur vide
		$error = array();

		// 1. Token
		extract($token);

		if (!password_verify($saveToken, $sentToken))
		{
			$error[] = 'Token';
		}

		// 2. Referer
		extract($referer);

		if (!preg_match('#^' . $saveReferer . '$#', $sentReferer))
		{
			$error[] = 'Referer';
		}

		// 3; id
		if ((int) $id <= 0)
		{
			$error[] = 'Id';
		}

		return $error;
	}

	public function roundCoord($coord)
	{
		if ((int) $coord < 1)
		{
			return substr($coord, 0, -6);
		}
		else
		{
			return substr($coord, 0, -5);
		}
	}
}	