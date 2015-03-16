<?php
$namespace = "App\\DataSources\\Mappings";

$entities = [];
$embeddables = [];

foreach ((new DirectoryIterator(base_path('src/DataSources/Mappings/Entities'))) as $fileInfo)
{
	/** @type $fileInfo DirectoryIterator */
	if ($fileInfo->getExtension() == 'php')
	{
		$entities[] = "$namespace\\Entities\\" . $fileInfo->getBasename('.php');
	}
}

foreach ((new DirectoryIterator(base_path('src/DataSources/Mappings/Embeddables'))) as $fileInfo)
{
	/** @type $fileInfo DirectoryIterator */
	if ($fileInfo->getExtension() == 'php')
	{
		/** @type $fileInfo SplFileInfo */
		$embeddables[] = "$namespace\\Embeddables\\" . $fileInfo->getBasename('.php');
	}
}
return [
	'entities'    => $entities,
	'embeddables' => $embeddables
];
 