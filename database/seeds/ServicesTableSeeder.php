<?php

use Illuminate\Database\Seeder;
use App\Service;
class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'name' => 'Criminal Case'
        ]);

        Service::create([
            'name' => 'Labor Case'
        ]);

        Service::create([
            'name' => 'Civil Case'
        ]);

        Service::create([
            'name' => 'Administrative Case'
        ]);

        Service::create([
            'name' => 'Other Quash-Judicial Case'
        ]);
    }
}
