<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Community::factory(10)->create();
        \App\Models\CommunityMember::factory(10)->create();
        \App\Models\CommunityMessage::factory(10)->create();
        \App\Models\CommunityStatus::factory(10)->create();
        \App\Models\DirectMessage::factory(10)->create();
        \App\Models\Event::factory(10)->create();
        \App\Models\EventType::factory(10)->create();
        \App\Models\Form::factory(10)->create();
        \App\Models\FormAnswer::factory(10)->create();
        \App\Models\FormAnswerUser::factory(10)->create();
        \App\Models\FormQuestion::factory(10)->create();
        \App\Models\Movie::factory(10)->create();
        \App\Models\MovieRating::factory(10)->create();
        \App\Models\UserFollow::factory(10)->create();
        \App\Models\UserFriend::factory(10)->create();
        \App\Models\UserStatus::factory(10)->create();
    }
}
