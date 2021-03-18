<?php

namespace Database\Seeders;

use App\Models\Transport;
use App\Models\User;
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
        User::create([
            "name" => "Administrator",
            "code" => \Str::upper(\Str::random(11)),
            "email" => "admin@admin.com",
            "phone" => "8904000000000",
            "password" => \Hash::make("1234"),
            "role_id" => 1,
            "email_verified_at" => now()
        ]);

        for ($countDriver = 0; $countDriver < 50; $countDriver++) {
            $driverUser = User::create([
                "name" => "Driver" . $countDriver,
                "code" => \Str::upper(\Str::random(11)),
                "email" => "driver" . $countDriver .  "@admin.com",
                "phone" => "89040000000" . $countDriver,
                "password" => \Hash::make("qw1234"),
                "role_id" => 4,
                "email_verified_at" => now()
            ]);

            Transport::create([
                "user_id" => $driverUser->id,
                "capacity" => 10.0
            ]);
        }
    }
}
