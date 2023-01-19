<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $groupsId = DB::table('groups')->insertGetId([
            'name' => 'Administrator',
            'user_id' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if ($groupsId > 0) {
            $userId =  DB::table('users')->insertGetId([
                'name' => 'Dinh Chung',
                'email' => 'dinhquangchung.k9sh@gmail.com',
                'password' => Hash::make('123456'),
                'group_id' => $groupsId,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        if ($userId > 0) {
            for ($i = 1; $i < 5; $i++) {
                DB::table('posts')->insert([
                    'title' => 'Trung ương Đảng đồng ý để Chủ tịch nước Nguyễn Xuân Phúc thôi giữ các chức vụ',
                    'content' => 'Ban Chấp hành Trung ương Đảng đồng ý để ông Nguyễn Xuân Phúc thôi giữ các chức vụ Ủy viên Bộ Chính trị, Ủy viên Ban Chấp hành Trung ương Đảng khóa XIII, Chủ tịch nước, Chủ tịch Hội đồng Quốc phòng, an ninh nhiệm kỳ 2021 - 2026',
                    'user_id' => $userId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
