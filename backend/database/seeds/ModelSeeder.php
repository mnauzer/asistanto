<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\OrderStatus;
use App\OrderType;


class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = File::get('database/data/Employee.json');
        $data = json_decode($employees, true);
        foreach ($data as $obj) {
            Employee::create($obj);
        };

        $order_type = File::get('database/data/OrderType.json');
        $data = json_decode($order_type, true);
        foreach ($data as $obj) {
            OrderType::create($obj);
        };

        $order_status = File::get('database/data/OrderStatus.json');
        $data = json_decode($order_status, true);
        foreach ($data as $obj) {
            OrderStatus::create($obj);
        };
    }
}
