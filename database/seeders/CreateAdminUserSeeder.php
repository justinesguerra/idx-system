<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'Justin Esguerra',
                'email' => 'esguerra.justin28@gmail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Dennis Bello',
                'email' => 'dbc0429@gmail.com',
                'password' => bcrypt('password')
            ]
        ];
        
        $role = Role::firstOrCreate(['name' => 'Admin']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        foreach ($usersData as $userData) {
            $user = User::updateOrCreate(['email' => $userData['email']], $userData);
            $user->assignRole($role);
            $role->syncPermissions($permissions);
        }
    }
}