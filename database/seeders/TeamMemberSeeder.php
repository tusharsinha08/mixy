<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Marcosinacioluz',
                'role' => 'Designer',
                'image' => 'assets/images/teams/leader1-about2-1.jpg'
            ],
            [
                'name' => 'Wingcitymedia',
                'role' => 'Photographer', 
                'image' => 'assets/images/teams/leader2-about2-1.jpg'
            ],
            [
                'name' => 'Tee3sports',
                'role' => 'Designer',
                'image' => 'assets/images/teams/leader3-about2-1.jpg'
            ],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}