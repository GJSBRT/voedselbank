<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Ismail',
            'last_name' => 'Gençer',
            'role_id' => 1,
            'email' => '97070695@st.deltion.nl',
            'password' => bcrypt('ismail'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Gijsbert',
            'last_name' => 'Gemert',
            'role_id' => 1,
            'email' => '97087855@st.deltion.nl',
            'password' => bcrypt('gijsbert'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Nikai',
            'last_name' => 'Delfgou',
            'role_id' => 1,
            'email' => '97072138@st.deltion.nl',
            'password' => bcrypt('nikai'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Quinten',
            'last_name' => 'Hofmeijer',
            'role_id' => 1,
            'email' => '97067140@st.deltion.nl',
            'password' => bcrypt('quinten'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        User::factory(10)->create();
    }
}