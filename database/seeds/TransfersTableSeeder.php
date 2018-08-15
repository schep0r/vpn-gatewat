<?php

use Illuminate\Database\Seeder;

class TransfersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        $users->each(function ($u) {
            $u->transfers()->saveMany(factory(App\Models\Transfer::class, 3)
                ->make()
            );
        });
    }
}
