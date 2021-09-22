<?php

use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Device::class, 50)
            ->create()
            ->each(function ($device) {
                $device->locations()->save(factory(App\Location::class)->make());
                $device->values()->createMany(factory(App\Value::class, 10)->make()->toArray());
            });
    }
}
