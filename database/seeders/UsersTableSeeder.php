<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        for ($i = 1; $i <= 101; $i++) {
            if($i == 1){
                $user_name = "admin";
                $role = "A";
            }elseif($i <= 51){
                $user_name = "test".($i-1);
                $role = "U";
            }else{
                $user_name = "nutri".($i-51);
                $role = "N";
            }

            $users[] = [
                'name' => $user_name,
                'email' => $user_name . '@gmail.com',
                'password' => Hash::make($user_name),
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->user->insert($users);

    }
}
