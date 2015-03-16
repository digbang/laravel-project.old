<?php namespace App\DataSources\Mappings\Entities;

use Digbang\Doctrine\Metadata\Builder;
use Digbang\Doctrine\Metadata\EntityMapping;
use Digbang\Security\Entities\User;
use Digbang\Security\Mappings\UserMappingHelper;

class BackofficeUserMapping implements EntityMapping
{
	/**
	 * Load the entity's metadata through the Metadata Builder object.
	 *
	 * @param Builder $builder
	 *
	 * @return void
	 */
	public function build(Builder $builder)
	{
		(new UserMappingHelper())->addMappings($builder);
	}

	/**
	 * Returns the fully qualified name of the entity that this mapper maps.
	 * This needs to be static so that we can load all entity mapping names
	 * without instantiating all EntityMapping classes.
	 *
	 * @return string
	 */
	public static function getEntityName()
	{
		return User::class;
	}
}
