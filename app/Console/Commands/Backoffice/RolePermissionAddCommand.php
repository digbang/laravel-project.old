<?php

namespace App\Console\Commands\Backoffice;

use Digbang\Security\Permissions\Permissible;
use Digbang\Security\Roles\Role;
use Digbang\Security\SecurityContext;
use Digbang\Security\Users\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;

class RolePermissionAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backoffice:roles:permissions:add {role} {permission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a permission to a backoffice role.';

    /**
     * Execute the console command.
     *
     * @param SecurityContext $securityContext
     * @param EntityManager   $entityManager
     */
    public function handle(SecurityContext $securityContext, EntityManager $entityManager)
    {
        $security = $securityContext->getSecurity('backoffice');

        $roleSlug = $this->argument('role');
        $permission = $this->argument('permission');

        /** @type Role|Permissible $role */
        $role = $security->roles()->findOneBy(['slug' => $roleSlug]);

        if (! $role)
        {
            $this->error("Role [$roleSlug] does not exist.");
            exit(1);
        }

        if (! $role instanceof Permissible)
        {
            $this->error("The configured Role class needs to extend " . Permissible::class .
                " to use permissions."
            );
            exit(2);
        }

        $role->addPermission($permission);
        $entityManager->flush($role);

        $this->info("Permission [$permission] added to role [$roleSlug].");
    }
}