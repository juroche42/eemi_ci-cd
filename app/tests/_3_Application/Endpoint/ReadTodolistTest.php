<?php

namespace App\Tests\_3_Application;

use App\Tests\_3_Application\AbstractApiTest;

class ReadTodolistTest extends AbstractApiTest
{
	public function setUp(): void
	{
		parent::setUp();

		$this->iri = '/api/todolists';
	}

	public function test_read_one_with_a_valid_id(): void
	{
		parent::test_read_one_with_a_valid_id();
	}

	public function test_read_one_with_an_invalid_id(): void
	{
		parent::test_read_one_with_an_invalid_id();
	}
}
