<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Entity
use NAO\BirdBundle\Entity\Observation;
use NAO\BirdBundle\Entity\User;


class DefaultControllerTest extends WebTestCase
{
	// Test de la page d'accueil
	public function testIndex()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	// Test de route
	public function testAboutRoute()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/about');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	// Test de route
	public function testContactRoute()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/contact');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	// Test d'objet
	public function testObsObject()
	{
		$this->assertObjectHasAttribute('birdname', new Observation);
		$this->assertObjectHasAttribute('species', new Observation);
		$this->assertObjectHasAttribute('date', new Observation);
		$this->assertObjectHasAttribute('longitude', new Observation);
		$this->assertObjectHasAttribute('latitude', new Observation);
	}

	// Test d'objet
	public function testUserObject()
	{
		$this->assertObjectHasAttribute('firstname', new User);
		$this->assertObjectHasAttribute('lastname', new User);
		$this->assertObjectHasAttribute('username', new User);
		$this->assertObjectHasAttribute('password', new User);
		$this->assertObjectHasAttribute('roles', new User);
		$this->assertObjectHasAttribute('createAt', new User);
	}

}
