<?php namespace Tests\IntegrationTests;

class HomeTest extends TestCase
{
	/** @test */
	public function it_should_show_the_hello_template()
	{
		$this->call('GET', '/');

		$this->assertResponseOk();
	}
}
