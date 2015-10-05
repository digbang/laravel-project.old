<?php
namespace Tests\Application;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    public function test_backoffice_redirects_to_auth()
    {
        $this
            ->visit('/backoffice')
            ->landOn('/backoffice/auth/login');
    }
}
