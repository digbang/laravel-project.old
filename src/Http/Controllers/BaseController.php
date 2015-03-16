<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\View\Factory;

/**
 * Class BaseController
 *
 * @property Request           request
 * @property UrlGenerator      url
 * @property Redirector        redirect
 * @property Factory           view
 * @property ValidationFactory validation
 *
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
	private $magicProperties = [
		'request'    => Request::class,
		'url'        => UrlGenerator::class,
		'redirect'   => Redirector::class,
		'view'       => Factory::class,
		'validation' => ValidationFactory::class
	];

	public function __get($property)
	{
		if (array_key_exists($property, $this->magicProperties))
		{
			if (! is_object($this->magicProperties[$property]))
			{
				$this->magicProperties[$property] = App::make($this->magicProperties[$property]);
			}

			return $this->magicProperties[$property];
		}

		throw new \BadMethodCallException("Property $property does not exist.");
	}
}
