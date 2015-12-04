<?php
namespace App\Console\Commands\Backoffice;

use Digbang\Security\Permissions\Permissible;
use Digbang\Security\SecurityContext;
use Digbang\Security\Users\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;

class UserPermissionAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backoffice:users:permissions:add {username : The username of the user} {permissions : A comma-separated list of permissions}';

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
        $permissions = $this->argument('permissions');

        /** @var User|Permissible $user */
        $user = $security->users()->findOneBy(['username' => $username]);

        if (!$user)
        {
            $this->error("Username [$username] does not exist.");
            exit(1);
        }

        if (!$user instanceof Permissible)
        {
            $this->error('The configured User class needs to extend ' . Permissible::class .
                ' to use permissions.'
            );
            exit(2);
        }

        foreach (explode(',', $permissions) as $permission)
        {
            $user->addPermission($permission);
            $this->info("Permission [$permission] added to user [$username].");
        }

        $entityManager->flush($user);
    }
}
