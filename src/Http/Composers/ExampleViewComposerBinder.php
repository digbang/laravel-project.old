<?php namespace App\Http\Composers;

use App\Contracts\Http\ViewComposerBinder;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

class ExampleViewComposerBinder implements ViewComposerBinder
{
    /**
     * Binds composers to the viewFactory.
     *
     * @param \Illuminate\View\Factory $viewFactory
     * @return void
     */
    public function bind(ViewFactory $viewFactory)
    {
        $viewFactory->composer('an.example.view', function(View $view){
            // Bind something to a specific view
            return $view->with([
                'anExampleBinding' => 'Hello!'
            ]);
        });
    }
}
