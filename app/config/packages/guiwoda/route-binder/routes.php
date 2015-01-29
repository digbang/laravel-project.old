<?php
$namespace = "App\\Http\\";

$classes = [];
foreach (new \DirectoryIterator(base_path('src/Http/Routes')) as $fileInfo)
{
    if (! $fileInfo->isDot() && $fileInfo->getExtension() == 'php')
    {
        $classes[] = "$namespace\\Routes\\" . $fileInfo->getBasename('.php');
    }
}

foreach (new \DirectoryIterator(base_path('src/Http/Filters')) as $fileInfo)
{
    if (! $fileInfo->isDot() && $fileInfo->getExtension() == 'php')
    {
        $classes[] = "$namespace\\Filters\\" . $fileInfo->getBasename('.php');
    }
}

return $classes;
