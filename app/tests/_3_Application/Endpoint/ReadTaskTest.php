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

	public function test_read_one_with_a_valid_id(): void
	{
		parent::test_read_one_with_a_valid_id();
	}

	public function test_read_one_with_an_invalid_id(): void
	{
		parent::test_read_one_with_an_invalid_id();
	}

	public function test_read_all_with_a_valid_id_and_valid_tag_id_filter(): void
	{
		$validTagId = 6;
		$this->iri .= '?tags%5B%5D=' . $validTagId;
		$this->test_read_all_by_valid_tag('id', $validTagId);
	}

	public function test_read_all_with_a_valid_id_and_valid_tag_name_filter(): void
	{
		$validTagName = 'Urgent';
		$this->iri .= '?tags.name%5B%5D=' . $validTagName;;
		$this->test_read_all_by_valid_tag('name', $validTagName);
	}

	public function test_read_all_with_a_valid_id_and_invalid_tag_id_filter(): void
	{
		$this->iri .= '?tags%5B%5D=0';
		$this->test_read_all_by_invalid_tag();
	}

	public function test_read_all_with_a_valid_id_and_invalid_tag_name_filter(): void
	{
		$this->iri .= '?tags.name%5B%5D=NotAValidTag';
		$this->test_read_all_by_invalid_tag();
	}

	/* ***************************************************** *\
		Support methods
	\* ***************************************************** */

	private function test_read_all_by_valid_tag(string $key, string $validTag): void
	{
		$this->makeRequest('GET');

		$this->assertResponseStatusCodeSame(200);
		$this->assertNotEmpty($this->responseContent);

		/** @var Task $task */
		foreach ($this->responseContent as $task)
		{
			$this->assertNotEmpty($task['tags']);
			$this->assertTrue(in_array($validTag, array_column($task['tags'], $key)));
		}
	}

	private function test_read_all_by_invalid_tag(): void
	{
		$this->makeRequest('GET');

		$this->assertResponseStatusCodeSame(200);
		$this->assertEmpty($this->responseContent);
	}
}
