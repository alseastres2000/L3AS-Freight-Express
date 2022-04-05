<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pathToFile = storage_path('app/public/attachments/');

        $data = array(
            [
                'name' => 'Super Admin',
                'email' => 'admin@l3a.test',
                'role' => 0,
                'password' => Hash::make('Zxasqw12'),
                'email_verified_at' => Carbon::now()
            ],
            [
                'name' => 'Office Staff',
                'email' => 'staff1@l3a.test',
                'role' => 1,
                'password' => Hash::make('Zxasqw12'),
                'email_verified_at' => Carbon::now()
            ],
            [
                'name' => 'Field Staff',
                'email' => 'staff2@l3a.test',
                'role' => 2,
                'password' => Hash::make('Zxasqw12'),
                'email_verified_at' => Carbon::now()
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@l3a.test',
                'role' => 3,
                'password' => Hash::make('Zxasqw12'),
                'email_verified_at' => Carbon::now()
            ],
        );

        foreach($data as $user) {
            User::create($user);
        }

        if(File::exists($pathToFile))
        {
            File::deleteDirectory($pathToFile);
        }
    }
}
