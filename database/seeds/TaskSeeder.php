<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('tasks')->insert([
        //     [
        //         'id'          => 1,
        //         'assignee_id' => 1,
        //         'created_by'  => 1,
        //         'case_id'     => 1,
        //         'stage_id'    => null,
        //         'name'        => 'Create Report About This case',
        //         'due_date'    => '2021-02-22',
        //         'priority'    => 'High',
        //         'description' => '<p>Create Report About This case urgent.<br></p>',
        //         'progress'    => null,
        //         'status'      => 0,
        //         'created_at'  => '2021-02-17 06:42:24',
        //         'updated_at'  => '2021-02-17 06:42:24',
        //     ],
        //     [
        //         'id'          => 2,
        //         'assignee_id' => 1,
        //         'created_by'  => 1,
        //         'case_id'     => 2,
        //         'stage_id'    => null,
        //         'name'        => 'Find out the evidence about this case.',
        //         'due_date'    => '2021-02-25',
        //         'priority'    => 'Medium',
        //         'description' => '<p>Find out the evidence about this case.<br></p>',
        //         'progress'    => null,
        //         'status'      => 0,
        //         'created_at'  => '2021-02-17 06:43:50',
        //         'updated_at'  => '2021-02-17 06:43:50',
        //     ],
        //     [
        //         'id'          => 3,
        //         'assignee_id' => 1,
        //         'created_by'  => 1,
        //         'case_id'     => 3,
        //         'stage_id'    => null,
        //         'name'        => 'Collect the evidence and submit to court.',
        //         'due_date'    => '2021-03-06',
        //         'priority'    => 'Low',
        //         'description' => null,
        //         'progress'    => null,
        //         'status'      => 1,
        //         'created_at'  => '2021-02-17 06:45:27',
        //         'updated_at'  => '2021-02-17 06:45:49',
        //     ],
        // ]);

        $permissions = [
            'staffs.index', 'staffs.edit', 'staffs.view', 'staffs.create',
            'permission.roles.index', 'permission.roles.edit', 'permission.roles.view', 'permission.roles.create',
            'permission.permissions.index',
            'events.index', 'events.edit', 'events.view', 'events.create',
            'payroll.index', 'payroll.edit', 'payroll.view', 'payroll.create',
            'genrate_payroll', 'staff_search_for_payroll',
            'registration.lawyer.pending', 'registration.lawyer.approve', 'registration.lawyer.show',
            'attendances.index',
            'attendance_report.index', 'attendance_report.search',
            'payroll_reports.index', 'payroll_reports.search',
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Create Admin role if not exists
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // Give all permissions to Admin role
        $adminRole->syncPermissions($permissions);

        // Assign Admin role to user id = 1
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }

}
