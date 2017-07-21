<?php

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            ['category_id' => 3, 'title' => 'Orchestra', 'description' => 'Play the instruments in harmony to win the hearts', 'rules' => '10 per team and Only one team per College, 12 minutes on stage inclusive of setup/plug in time, Pre-recorded sound is not allowed, Participants must bring their own instruments, Only Tamil songs, More marks for own composition, Vulgarity in any sorts will lead to disqualification, Jury decision is final, Reporting time 9.30 AM', 'event_date' => '2016-06-07', 'start_time' => '10:30', 'end_time' => '13:00', 'min_members' => 2, 'max_members' => 10, 'max_limit' => 10, 'contact_email' => 'orchestralegacy16@gmail.com'],

            ['category_id' => 1, 'title' => 'Martial Arts', 'description' => 'It is game for self defence', 'rules' => 'Maximum of 1 participant per College, All the necessary items should be brought by participant, Individual Performance alone is considered, Karate, Silambam, Kalari, Take-Wan-Do movements is to be performed (For Karate and Take-Wan-Do only kattas are allowed), Reporting time 10:00 AM', 'event_date' => '2016-06-07', 'start_time' => '10:30', 'end_time' => '13:00', 'min_members' => 1, 'max_members' => 1, 'max_limit' => 10, 'contact_email' => 'martialartlegacy16@gmail.com'],

            ['category_id' => 2, 'title' => 'CINEMATRIX', 'description' => 'It is short film contest', 'rules' => 'Maximum of 8 members per team, Theme: Any, Duration: 15 min (including title and credits), Send the YouTube link or Share via Google Drive shortfilmlegacy17@gmail.com before 5th Sep 2016, Best 10 films will be selected for finals, Cinematography, editing and story will play as the major score points, Avoid help from professional artists, Reporting time 9.30 AM', 'event_date' => '2016-06-07', 'start_time' => '10:00', 'end_time' => '12:30', 'min_members' => 1, 'max_members' => 1, 'max_limit' => 10, 'contact_email' => 'shortfilmlegacy16@gmail.com'],

            ['category_id' => 3, 'title' => 'Dance', 'description' => 'Dance in rhythm to win the hearts', 'rules' => '10 per team and Only one team per College, 12 minutes on stage inclusive of setup/plug in time, Pre-recorded sound is not allowed, Participants must bring their own instruments, Only Tamil songs, More marks for own composition, Vulgarity in any sorts will lead to disqualification, Jury decision is final, Reporting time 9.30 AM', 'event_date' => '2016-06-08', 'start_time' => '10:30', 'end_time' => '13:00', 'min_members' => 2, 'max_members' => 10, 'max_limit' => 10, 'contact_email' => 'orchestralegacy16@gmail.com']
        ]);
    }
}
