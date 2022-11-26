<?php

namespace App\Tests\_3_Application\Endpoint;

use App\Tests\_3_Application\Endpoint\AbstractEndpointTest;

class ReadTaskTest extends AbstractEndpointTest
{
	public function setUp(): void
	{
		parent::setUp();

		$this->iri = '/api/tasks';
	}

	public function test_read_with_a_valid_id(): void
	{
		parent::test_read_with_a_valid_id();
	}

	public function test_read_with_an_invalid_id(): void
	{
		parent::test_read_with_an_invalid_id();
	}
}
