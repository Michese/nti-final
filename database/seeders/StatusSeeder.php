<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            "title" => "Ожидание за воротами"
        ]);

        $status2 = new Status();
        $status2->fill([
            "title" => "Проезд через ворота"
        ]);
        $status2->duration = 5;
        $status2->save();

        $status3 = new Status();
        $status3->fill([
            "title" => "Перемещение на склад"
        ]);
        $status3->duration = 10;
        $status3->save();

        Status::create([
            "title" => "Ожидание погрузки"
        ]);


        $status5 = new Status();
        $status5->fill([
            "title" => "Погрузка"
        ]);
        $status5->duration = 10;
        $status5->save();

        $status6 = new Status();
        $status6->fill([
            "title" => "Перемещение на выезд"
        ]);
        $status6->duration = 10;
        $status6->save();

        Status::create([
            "title" => "Ожидание выезда"
        ]);

        $status8 = new Status();
        $status8->fill([
            "title" => "Выезд с территории"
        ]);
        $status8->duration = 5;
        $status8->save();

        Status::create([
            "title" => "Выполнен"
        ]);
    }
}
