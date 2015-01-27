<?php namespace App\Contracts\Http;

use Illuminate\View\Factory as ViewFactory;

interface ViewComposerBinder
{
    /**
     * Binds composers to the viewFactory.
     *
     * @param \Illuminate\View\Factory $viewFactory
     * @return void
     */
	public function bind(ViewFactory $viewFactory);
}
