<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');
        $config['users'] = 'users';

        Schema::create($config['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create($config['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create($config['user_has_permissions'], function (Blueprint $table) use ($config) {
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on($config['users'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($config['permissions'])
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create($config['user_has_roles'], function (Blueprint $table) use ($config) {
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($config['users'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);

            Schema::create($config['role_has_permissions'], function (Blueprint $table) use ($config) {
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($config['permissions'])
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($config['roles'])
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);
            });
        });

        $this->setupDefaultPermissions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('laravel-permission.table_names');

        Schema::drop($config['role_has_permissions']);
        Schema::drop($config['user_has_roles']);
        Schema::drop($config['user_has_permissions']);
        Schema::drop($config['roles']);
        Schema::drop($config['permissions']);
    }

    private function setupDefaultPermissions()
    {
        //admin role and permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::create(['name' => 'access-admin']));
        $role->givePermissionTo(Permission::create(['name' => 'view-users']));
        $role->givePermissionTo(Permission::create(['name' => 'edit-users']));
        $role->givePermissionTo(Permission::create(['name' => 'create-users']));
        $role->givePermissionTo(Permission::create(['name' => 'delete-users']));
        $role->givePermissionTo(Permission::create(['name' => 'view-candidates']));
        $role->givePermissionTo(Permission::create(['name' => 'edit-candidates']));
        $role->givePermissionTo(Permission::create(['name' => 'create-candidates']));
        $role->givePermissionTo(Permission::create(['name' => 'delete-candidates']));

        //round 1 judge roles
        $permission = Permission::create(['name' => 'judge-round1']);
        $role = Role::create(['name' => 'judge 1 [academic]']);
        $role->givePermissionTo($permission);
        $role = Role::create(['name' => 'judge 1 [student affairs]']);
        $role->givePermissionTo($permission);
        $role = Role::create(['name' => 'judge 1 [alumni]']);
        $role->givePermissionTo($permission);

        //round 2 judge role
        $role = Role::create(['name' => 'judge 2']);
        $role->givePermissionTo('view-candidates');
        $role->givePermissionTo(Permission::create(['name' => 'judge-round2']));
    }
}
