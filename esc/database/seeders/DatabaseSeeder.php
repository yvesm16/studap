<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('course')->insert([
            'id' => 1,
            'slug' => md5(1),
            'text' => 'Bachelor of Science in Information Technology',
            'chairperson' => 2,
            'director' => 3,
            'secretary' => 4,
            'status' => 1
        ]);

        DB::table('course')->insert([
            'id' => 2,
            'slug' => md5(2),
            'text' => 'Bachelor of Science in Computer Science',
            'chairperson' => 6,
            'director' => 3,
            'secretary' => 4,
            'status' => 1
        ]);

        DB::table('course')->insert([
            'id' => 3,
            'slug' => md5(3),
            'text' => 'Bachelor of Science in Information System',
            'chairperson' => 7,
            'director' => 3,
            'secretary' => 4,
            'status' => 1
        ]);

        DB::table('concerns')->insert([
            'id' => 1,
            'slug' => md5(1),
            'text' => 'Project Deliverables',
            'status' => 1
        ]);

        DB::table('concerns')->insert([
            'id' => 2,
            'slug' => md5(2),
            'text' => 'Grade Consultation',
            'status' => 1
        ]);

        DB::table('concerns')->insert([
            'id' => 3,
            'slug' => md5(3),
            'text' => 'Inquiries about the lesson',
            'status' => 1
        ]);

        DB::table('concerns')->insert([
            'id' => 4,
            'slug' => md5(4),
            'text' => 'Capstone Project',
            'status' => 1
        ]);

        DB::table('concerns')->insert([
            'id' => 5,
            'slug' => md5(5),
            'text' => 'Others',
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'slug' => md5(1),
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'john.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 0,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'slug' => md5(2),
            'fname' => 'Jane',
            'lname' => 'Doe',
            'email' => 'jane.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'slug' => md5(3),
            'fname' => 'Mark',
            'lname' => 'Doe',
            'email' => 'mark.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 2,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'slug' => md5(4),
            'fname' => 'Mary',
            'lname' => 'Doe',
            'email' => 'mary.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 3,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'slug' => md5(5),
            'fname' => 'Paul',
            'lname' => 'Doe',
            'email' => 'paul.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 4,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'slug' => md5(6),
            'fname' => 'Perl',
            'lname' => 'Doe',
            'email' => 'perl.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 2,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'slug' => md5(7),
            'fname' => 'Sean',
            'lname' => 'Doe',
            'email' => 'sean.doe@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 2,
            'verified' => 1,
            'status' => 1
        ]);


        // DB::table('professor_schedule')->insert([
        //     'id' => 1,
        //     'slug' => md5(1),
        //     'professor_id' => 2,
        //     'student_id' => 1,
        //     'title' => 'Appointment',
        //     'start_time' => '2021-06-17 13:00:00',
        //     'end_time' => '2021-06-17 13:30:00',
        //     'concerns' => '1;3;5',
        //     'concerns_others' => 'Other Stuff',
        //     'status' => 0,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 2,
        //     'slug' => md5(2),
        //     'professor_id' => 2,
        //     'student_id' => 1,
        //     'title' => 'Appointment',
        //     'start_time' => '2021-06-17 14:00:00',
        //     'end_time' => '2021-06-17 14:30:00',
        //     'concerns' => '2',
        //     'concerns_others' => '',
        //     'status' => 0,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 3,
        //     'slug' => md5(3),
        //     'professor_id' => 2,
        //     'student_id' => 1,
        //     'title' => 'Appointment',
        //     'start_time' => '2021-07-17 14:30:00',
        //     'end_time' => '2021-07-17 15:00:00',
        //     'concerns' => '4',
        //     'concerns_others' => '',
        //     'status' => 0,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 4,
        //     'slug' => md5(4),
        //     'professor_id' => 2,
        //     'student_id' => 1,
        //     'title' => 'Appointment',
        //     'start_time' => '2021-07-16 10:00:00',
        //     'end_time' => '2021-07-16 10:30:00',
        //     'concerns' => '1;2',
        //     'concerns_others' => '',
        //     'status' => 0,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 5,
        //     'slug' => md5(5),
        //     'professor_id' => 2,
        //     'student_id' => 1,
        //     'title' => 'Appointment',
        //     'start_time' => '2021-07-18 15:30:00',
        //     'end_time' => '2021-07-18 16:00:00',
        //     'concerns' => '5',
        //     'concerns_others' => 'Hello World',
        //     'status' => 0,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 6,
        //     'slug' => md5(6),
        //     'professor_id' => 2,
        //     'title' => 'Elective 1',
        //     'start_time' => '2021-07-16 08:00:00',
        //     'end_time' => '2021-07-16 09:00:00',
        //     'concerns' => '',
        //     'concerns_others' => '',
        //     'status' => 1,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 7,
        //     'slug' => md5(7),
        //     'professor_id' => 2,
        //     'title' => 'Elective 2',
        //     'start_time' => '2021-07-16 09:00:00',
        //     'end_time' => '2021-07-16 10:00:00',
        //     'concerns' => '',
        //     'concerns_others' => '',
        //     'status' => 1,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 8,
        //     'slug' => md5(8),
        //     'professor_id' => 3,
        //     'title' => 'Elective 1',
        //     'start_time' => '2021-07-17 08:00:00',
        //     'end_time' => '2021-07-17 09:00:00',
        //     'concerns' => '',
        //     'concerns_others' => '',
        //     'status' => 1,
        // ]);
        //
        // DB::table('professor_schedule')->insert([
        //     'id' => 9,
        //     'slug' => md5(9),
        //     'professor_id' => 3,
        //     'title' => 'Elective 2',
        //     'start_time' => '2021-07-20 09:00:00',
        //     'end_time' => '2021-07-20 10:00:00',
        //     'concerns' => '',
        //     'concerns_others' => '',
        //     'status' => 1,
        // ]);

    }
}
