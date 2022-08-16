<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB; 

class FootertextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footertexts')->insert([
            'copyright' => '<p class="mb-0">Copyright © 2022 <a href="https://adaa.sd/"> AdaaHelp </a>. Developed by <a href="https://smart.sd/">Smart Team</a></p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
