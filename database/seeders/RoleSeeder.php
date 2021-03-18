<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
           "title" => "Администратор"
        ]);

        Role::create([
            "title" => "Владелец"
        ]);

        Role::create([
            "title" => "Диспетчер"
        ]);

        Role::create([
            "title" => "Водитель"
        ]);

        Role::create([
            "title" => "Кладовщик"
        ]);

        Role::create([
            "title" => "Клиент"
        ]);
    }
}
