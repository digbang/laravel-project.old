<?php
$namespace = "App\\Http\\Routes\\";

$classes = [];
foreach (new \DirectoryIterator(base_path('src/Http/Routes')) as $fileInfo)
{
    if (! $fileInfo->isDot() && $fileInfo->getExtension() == 'php')
    {
        $classes[] = $namespace . $fileInfo->getBasename('.php');
    }
}

return $classes;
