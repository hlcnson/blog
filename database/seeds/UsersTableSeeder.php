<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Phương thức run() này để tạo dữ liệu mẫu sẽ được thực thi từ phương thức run()
        // của class DatabaseSeeder.

        // Tạo một user model (record) cho table Users
        $user = App\User::create([
        	'name' => 'Tom Hank',
        	'email' => 'tom@yahoo.com',
        	'password' => bcrypt('123456'),
            'admin' => 1
        ]);		// Hàm bcrypt để mã hóa password

        // Tạo một record tương ứng với record user vừa tạo ở trên trong bảng Profiles
        App\Profile::create([
            'user_id' => $user->id,
            'avatar' => 'uploads/avatars/avatar1.jpg',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum officiis quos unde amet ipsum vel ducimus quia ad.',
            'facebook' => 'facebook.com',
            'youtube' => 'youtube.com'
        ]); 
    }
}


