<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => "高橋",
                'under_name' =>"広昇",
                'over_name_kana' => "タカハシ",
                'under_name_kana' => "ヒロノリ",
                'mail_address' => "hiro.com",
                'password' => bcrypt("1234"),
                'sex' => "1",
                'birth_day' => "1998-02-11",
                'role' => "1",
            ]   
        ]);
    }
}