<?php
use Illuminate\Support\Facades\Storage;

$binders = function(){
    foreach (Storage::disk('local')->allFiles('Http/Routes') as $file)
    {
	    yield 'App\\' . str_replace(['/', '.php'], ['\\', ''], $file);
    }
};

return [ 'binders' => $binders() ];
