<?php

use App\Group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions admin
        Permission::create(['name' => 'create-group']);
        Permission::create(['name' => 'delete-group']);
        Permission::create(['name' => 'create-maintenance']);
        Permission::create(['name' => 'add-maintenance']);
        Permission::create(['name' => 'delete-maintenance']);
        Permission::create(['name' => 'register-device']);
        Permission::create(['name' => 'delete-device']);
        Permission::create(['name' => 'create-rule']);
        Permission::create(['name' => 'edit-rule']);
        Permission::create(['name' => 'delete-rule']);

        // create permissions maintenance



        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create-group');
        $adminRole->givePermissionTo('delete-group');
        $adminRole->givePermissionTo('create-maintenance');
        $adminRole->givePermissionTo('add-maintenance');
        $adminRole->givePermissionTo('delete-maintenance');
        $adminRole->givePermissionTo('register-device');
        $adminRole->givePermissionTo('delete-device');
        $adminRole->givePermissionTo('create-rule');
        $adminRole->givePermissionTo('edit-rule');
        $adminRole->givePermissionTo('delete-rule');


        $maintenanceRole = Role::create(['name' => 'maintenance']);

        $superAdminRole = Role::create(['name' => 'super-admin']);

        // crear usuarios

        $adminUser = factory(App\User::class)->create([
            'name' => 'Raúl Fernández',
            'email' => 'fdez@email.com'
        ]);
        $adminUser->assignRole($adminRole);
        $group = Group::create([
            'name' => 'Todos los Sensores',
            'description' => 'Aquí puedes visualizar todos tus dispositivos.'
        ]);
        $adminUser->groups()->attach($group->id, ['owner' => true]);

        $maintenanceUser = factory(App\User::class)->create([
            'name' => 'Cristina Díez',
            'email' => 'maintenance@email.com'
        ]);
        $maintenanceUser->assignRole($maintenanceRole);

        $superAdminUser = factory(App\User::class)->create([
            'name' => 'Super-Admin User',
            'email' => 'admin@admin.com',
        ]);
        $superAdminUser->assignRole($superAdminRole);
    }
}
