<?php

namespace Database\Seeders;

use App\Models\DeliveryTime;
use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '10 AM - 11 AM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '11 AM - 12 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '12 PM - 01 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '01 PM - 02 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '02 PM - 03 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '03 PM - 04 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '04 PM - 05 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '1',
                'time' => '05 PM - 06 PM',
            ]);

            DeliveryTime::create([
                'group_id'  => '2',
                'time' => '04 PM - 05 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '2',
                'time' => '05 PM - 06 PM',
            ]);
            DeliveryTime::create([
                'group_id'  => '2',
                'time' => '06 PM - 07 PM',
            ]);
        

    }
}
