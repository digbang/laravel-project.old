<?php

namespace App\Console\Commands\Backoffice;

use Digbang\Security\Roles\Role;
use Digbang\Security\Roles\Roleable;
use Digbang\Security\SecurityContext;
use Digbang\Security\Users\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;

class UserAddRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backoffice:users:roles:add {username} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a permission to a backoffice user.';

    /**
     * Execute the console command.
     *
     * @param SecurityContext $securityContext
     * @param EntityManager   $entityManager
     */
    public function handle(SecurityContext $securityContext, EntityManager $entityManager)
    {
        $security = $securityContext->getSecurity('backoffice');

        $username = $this->argument('username');
        $roleName = $this->argument('role');

        /** @type User|Roleable $user */
        $user = $security->users()->findOneBy(['username' => $username]);

        if (! $user)
        {
            $this->error("Username [$username] does not exist.");
            exit(1);
        }

        if (! $user instanceof Roleable)
        {
            $this->error("The configured User class needs to extend " . Roleable::class .
                " to use roles."
            );
            exit(2);
        }

        /** @type Role $role */
        $role = $security->roles()->findBySlug($roleName);

        if (! $role)
        {
            $this->error(
                "Role [$roleName] does not exist. " .
                "You must use the role slug to identify it."
            );

            exit(3);
        }

        $user->addRole($role);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->info("Role [$roleName] added to user [$username].");
    }
}