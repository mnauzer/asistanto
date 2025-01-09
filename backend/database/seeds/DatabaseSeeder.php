<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;
use App\Employee;
use App\OrderStatus;
use App\OrderType;
use App\EmployeeWage;
use App\Order;
use App\Customer;
use App\ExpenseCategory;
use App\ExpenseSubcategory;
use App\Job;
use App\Workhour;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@krajinka.online',
            'password' => Hash::make('simonka7510'),
            'avatar' => '/images/krajinka_logo_bw.svg',
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@krajinka.online',
            'password' => Hash::make('krajinka2018'),
            'avatar' => '/images/krajinka_logo_bw.svg',
        ]);
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@krajinka.online',
            'password' => Hash::make('krajinka2018'),
            'avatar' => '/images/krajinka_logo_bw.svg',
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@krajinka.online',
            'password' => Hash::make('krajinka2018'),
            'avatar' => '/images/krajinka_logo_bw.svg',
        ]);
        $visitor = User::create([
            'name' => 'Visitor',
            'email' => 'visitor@krajinka.online',
            'password' => Hash::make('krajinka2018'),
            'avatar' => '/images/krajinka_logo_bw.svg',
        ]);

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
    
        $employee_wage = File::get('database/data/EmployeeWages.json');
        $data = json_decode($employee_wage, true);
        foreach ($data as $obj) {
            EmployeeWage::create($obj);
        };

        $orders = File::get('database/data/Orders.json');
        $data = json_decode($orders, true);
        foreach ($data as $obj) {
            Order::create($obj);
        };
   
        $jobs = File::get('database/data/Jobs.json');
        $data = json_decode($jobs, true);
        foreach ($data as $obj) {
            Job::create($obj);
        };
      
        $workhours = File::get('database/data/Workhours.json');
        $data = json_decode($workhours, true);
        foreach ($data as $obj) {
            Workhour::create($obj);
        };

        $customers = File::get('database/data/Customers.json');
        $data = json_decode($customers, true);
        foreach ($data as $obj) {
            Customer::create($obj);
        };
        
        $expenseCategories = File::get('database/data/ExpenseCategories.json');
        $data = json_decode($expenseCategories, true);
        foreach ($data as $obj) {
            ExpenseCategory::create($obj);
        };
        $expenseSubcategories = File::get('database/data/ExpenseSubcategories.json');
        $data = json_decode($expenseSubcategories, true);
        foreach ($data as $obj) {
            ExpenseSubcategory::create($obj);
        };

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $editorRole = Role::findByName(\App\Laravue\Acl::ROLE_EDITOR);
        $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
        $visitorRole = Role::findByName(\App\Laravue\Acl::ROLE_VISITOR);
        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);
        $user->syncRoles($userRole);
        $visitor->syncRoles($visitorRole);
        $this->call(UsersTableSeeder::class);
    }
}
