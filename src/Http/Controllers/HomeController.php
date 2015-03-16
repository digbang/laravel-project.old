<?php namespace App\Http\Controllers;

class HomeController extends BaseController
{
	public function showWelcome()
	{
		return $this->view->make('templates/hello');
	}
}
