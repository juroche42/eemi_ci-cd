<?php

namespace App\Tests\_3_Application\Endpoint;

use Faker\Factory;
use Faker\Generator;
use ApiPlatform\Symfony\Bundle\Test\Client;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpClient\Exception\ClientException;

abstract class AbstractEndpointTest extends ApiTestCase
{
	protected ?Generator $faker = null;
	protected ?string $iri = null;
	protected ?array $validPayload = null;
	protected ?Client $client = null;
	protected ?array $responseContent = null;

	/* ********************************************************** *\
		Common setup
	\* ********************************************************** */

	protected function setUp(): void
	{
		parent::setUp();

		$this->client = static::createClient();
		$this->faker = Factory::create();
	}

	protected function tearDown(): void
	{
		$this->iri = null;
		$this->validPayload = null;

		parent::tearDown();
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
		$this->expectException(ClientException::class);
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

	/* ********************************************************** *\
		Generic request
	\* ********************************************************** */

	protected function makeRequest(string $method, ?array $payload = null): void
	{
		$options['headers']['accept'] = 'application/json';

		if ($method === 'POST')
			$options['headers']['content-type'] = 'application/json';

		if ($payload !== null)
			$options['json'] = $payload;

		$clientResponse = $this->client->request($method, $this->iri, $options);
		$this->responseContent = json_decode($clientResponse->getContent(), true);

		$this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
	}
}
