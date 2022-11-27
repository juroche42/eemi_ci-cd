<?php

namespace App\Tests\_3_Application;

use Exception;
use Faker\Factory;
use Faker\Generator;
use ApiPlatform\Symfony\Bundle\Test\Client;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\ServerException;

abstract class AbstractApiTest extends ApiTestCase
{
	protected Generator $faker;
	protected string $iri;
	protected array $validPayload;
	protected array $invalidPayload;
	protected Client $client;
	protected array $responseContent;

	/* ********************************************************** *\
		Common setup
	\* ********************************************************** */

	protected function setUp(): void
	{
		parent::setUp();

		$this->client = static::createClient();
		$this->faker = Factory::create();
	}

	/* ********************************************************** *\
		Common tests
	\* ********************************************************** */

	// --------- Create ---------

	protected function test_create_with_a_valid_payload(): void
	{
		$this->makeRequest('POST', $this->validPayload);

		$this->assertResponseStatusCodeSame(201);
		$this->assertArrayHasKey('id', $this->responseContent);
	}

	protected function test_create_with_an_invalid_payload(): void
	{
		$this->makeRequest('POST', $this->invalidPayload);

		$this->assertResponseStatusCodeSame(400);
	}

	// --------- Read ---------

	protected function test_read_one_with_a_valid_id(): void
	{
		$this->iri .= '/1';

		$this->makeRequest('GET');

		$this->assertResponseStatusCodeSame(200);
		$this->assertArrayHasKey('id', $this->responseContent);
		$this->assertSame($this->responseContent['id'], 1);
	}

	protected function test_read_one_with_an_invalid_id(): void
	{
		$this->iri .= '/0';

		$this->expectException(ClientException::class);
		$this->makeRequest('GET');

		$this->assertResponseStatusCodeSame(404);
	}

	// --------- Update ---------

	protected function test_update_with_a_valid_payload(): void
	{
		$this->makeRequest('PATCH', $this->validPayload);

		$this->assertResponseStatusCodeSame(200);
		$this->assertArrayHasKey('id', $this->responseContent);
	}

	protected function test_update_with_an_invalid_payload(): void
	{
		$this->expectException(ServerException::class);

		$this->makeRequest('PATCH', $this->invalidPayload);

		$this->assertResponseStatusCodeSame(400);
	}

	/* ********************************************************** *\
		Generic request
	\* ********************************************************** */

	protected function makeRequest(string $method, ?array $payload = null): void
	{
		$options['headers']['accept'] = 'application/json';

		if ($method === 'POST')
			$options['headers']['content-type'] = 'application/json';
		elseif ($method === 'PATCH')
			$options['headers']['content-type'] = 'application/merge-patch+json';

		if ($payload !== null)
			$options['json'] = $payload;

		$clientResponse = $this->client->request($method, $this->iri, $options);
		if (!is_array($responseArray = json_decode($clientResponse->getContent(), true)))
			throw new Exception('json_decode failed.');
		$this->responseContent = $responseArray;

		$this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
	}
}
