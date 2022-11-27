<?php

namespace App\Tests\_3_Application\Endpoint;

use App\Tests\_3_Application\Endpoint\AbstractEndpointTest;

class CreateTodolistTest extends AbstractEndpointTest
{
	public function setUp(): void
	{
		parent::setUp();

		$this->iri = '/api/todolists';
		$this->validPayload = [
			'name' => $this->faker->sentence()
		];
		$this->invalidPayload = [
			'name' => ''
		];
	}

	public function test_create_with_a_valid_payload(): void
	{
		parent::test_create_with_a_valid_payload();

		$this->assertArrayHasKey('name', $this->responseContent);
		$this->assertSame($this->responseContent['name'], $this->validPayload['name']);
	}

	public function test_create_with_an_invalid_payload(): void
	{
		parent::test_create_with_an_invalid_payload();
	}
}
