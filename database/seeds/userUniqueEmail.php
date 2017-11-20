<?php

use Illuminate\Database\Seeder;
use App\User;

class userUniqueEmail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')
            ->select(DB::raw('email, count(email) as count'))
            ->groupBy('email')
            ->having('count','>','1')
            ->get();
        foreach($users as $user){
            $count = User::where('email', $user->email)->get();

            $dups = User::where('email', $user->email)
                ->orderby('created_at', 'asc')
                ->skip(1)
                ->take(count($count) - 1)
                ->delete();
        }

    }
}



