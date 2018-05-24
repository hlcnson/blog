<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thực thi phương thức run() của class UsersTableSeeder để tạo dữ liệu mẫu
        // cho table Users.
        // Phương thức này sẽ được kích hoạt bằng lệnh <php artisan db:seed>
        $this->call(UsersTableSeeder::class);
    }
}
