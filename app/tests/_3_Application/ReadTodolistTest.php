<?php

namespace App\Tests\_3_Application;

use App\Entity\Todolist;
use ApiPlatform\Symfony\Bundle\Test\Client;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ReadTodolistTest extends ApiTestCase
{
	private Client $client;

	public function setUp(): void
	{
		$this->client = static::createClient();
	}

	public function test_read_todolist_number_one(): void
	{
		$this->makeRequest('GET', '1');
		$this->assertResponseIsSuccessful();
		$this->assertJsonContains(['@id' => '/api/todolists/1']);
	}

	private function makeRequest(string $method, ?string $id, array $payload = []): void
	{
		$iri = ($id !== null ? $this->findIriBy(Todolist::class, ['id' => $id]) : '/todolists');

		if ($payload !== [])
			$payload = ['json' => $payload];

		$this->client->request($method, $iri, $payload);
	}
}
