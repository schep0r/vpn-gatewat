<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Company::class, 4)
            ->create()
            ->each(function ($c) {
                $c->users()->saveMany(factory(App\Models\User::class, 7)
                    ->make()
                );
            });
    }
}
