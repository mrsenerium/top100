<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UpdateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::findByName('judge 1 [student affairs]');
        $role->update([
            'name'  => 'judge 1 [staff]'
        ]);

        $role = Role::findByName('judge 1 [academic]');
        $role->update([
            'name'  => 'judge 1 [academic-a]'
        ]);

        $permission = Permission::findByName('judge-round1');
        $role = Role::create(['name' => 'judge 1 [academic-b]']);
        $role->givePermissionTo($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $role = Role::findByName('judge 1 [staff]');
        $role->update([
            'name'  => 'judge 1 [student affairs]'
        ]);

        $role = Role::findByName('judge 1 [academic-a]');
        $role->update([
            'name'  => 'judge 1 [academic]'
        ]);

        $role = Role::findByName('judge 1 [academic-b]');
        $role->delete();
    }
}
