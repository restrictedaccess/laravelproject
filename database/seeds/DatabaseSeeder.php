<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call('assessmentFirstSentenceSeeder');
        $this->call('assessmentSecondSentenceSeeder');
        $this->call('reportDecisionSeeder');
        Model::reguard();
    }
}
