<?php

use Illuminate\Database\Seeder;

class lookupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('lookups')->insert([
            'kod' => 'status',
            'title' => 'Status',
            'master' => null
        ]);
        DB::table('lookups')->insert([
            'kod' => 'IN',
            'title' => 'IN',
            'master' => null
        ]);
        DB::table('lookups')->insert([
            'kod' => 'OUT',
            'title' => 'OUT',
            'master' => null
        ]);
        DB::table('lookups')->insert([
            'kod' => '1',
            'title' => 'Active',
            'master' => 1
        ]);
        DB::table('lookups')->insert([
            'kod' => '2',
            'title' => 'Deactive',
            'master' => 1
        ]);
        DB::table('lookups')->insert([
            'kod' => '1',
            'title' => 'To Saving',
            'master' => null
        ]);
        DB::table('lookups')->insert([
            'kod' => '1',
            'title' => 'Elaun',
            'master' => 2
        ]);
        DB::table('lookups')->insert([
            'kod' => '2',
            'title' => 'Freelance',
            'master' => 2
        ]);
        DB::table('lookups')->insert([
            'kod' => '3',
            'title' => 'Salary',
            'master' => 2
        ]);
        DB::table('lookups')->insert([
            'kod' => '4',
            'title' => 'Others',
            'master' => 2
        ]);
        DB::table('lookups')->insert([
            'kod' => '1',
            'title' => 'Reload Prepaid',
            'master' => 3
        ]);
        DB::table('lookups')->insert([
            'kod' => '2',
            'title' => 'Charity',
            'master' => 3
        ]);
        DB::table('lookups')->insert([
            'kod' => '3',
            'title' => 'Eat',
            'master' => 3
        ]);
        DB::table('lookups')->insert([
            'kod' => '4',
            'title' => 'Needs',
            'master' => 3
        ]);
        DB::table('lookups')->insert([
            'kod' => '5',
            'title' => 'Others',
            'master' => 3
        ]);
        DB::table('lookups')->insert([
            'kod' => 'Commitments',
            'title' => 'Commitments',
            'master' => null
        ]);
        DB::table('lookups')->insert([
            'kod' => '2',
            'title' => 'From Saving',
            'master' => null
        ]);
    }
}
