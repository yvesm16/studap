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
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Mildred',
            'lname' => 'Duran',
            'email' => 'mcduran@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'slug' => md5(2),
            'prefix'=> 'Asst. Prof. Dean',
            'fname' => 'Jerralyn',
            'lname' => 'Padua',
            'email' => 'jtpadua@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 2,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'slug' => md5(3),
            'prefix'=> '',
            'fname' => 'Juan',
            'lname' => 'Dela Cruz',
            'email' => 'student@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 0,
            'verified' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'slug' => md5(4),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Divinagracia',
            'lname' => 'Mariano',
            'email' => 'drmariano@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 3,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'slug' => md5(5),
            'prefix'=> 'Ms.',
            'fname' => 'Roma',
            'lname' => 'Gonzaga',
            'email' => 'rpgonzaga@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 5,
            'verified' => 1,
            'department' => 3,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'slug' => md5(6),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Khrisnamonte',
            'lname' => 'Balmeo',
            'email' => 'kmbalmeo@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'slug' => md5(7),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'William',
            'lname' => 'Cortez',
            'email' => 'wacortez@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);


        DB::table('users')->insert([
            'id' => 8,
            'slug' => md5(8),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Arne',
            'lname' => 'Barcelo',
            'email' => 'abbarcelo@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 9,
            'slug' => md5(9),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Rochelle ',
            'lname' => 'Lopez',
            'email' => 'rllopez@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 10,
            'slug' => md5(10),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Jose',
            'lname' => 'Seno',
            'email' => 'jlseno@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 11,
            'slug' => md5(11),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Christopher',
            'lname' => 'Ladao',
            'email' => 'cdladao@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 12,
            'slug' => md5(12),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Salve',
            'lname' => 'Diaz',
            'email' => 'sldiaz@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 13,
            'slug' => md5(13),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Imelda',
            'lname' => 'Marollano',
            'email' => 'iemarollano@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 14,
            'slug' => md5(14),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Alex',
            'lname' => 'Santos',
            'email' => 'aasantos@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 1,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 15,
            'slug' => md5(15),
            'prefix'=> 'Ms.',
            'fname' => 'Madonna',
            'lname' => 'Kho',
            'email' => 'mgkho@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 5,
            'verified' => 1,
            'department' => 3,
            'status' => 1
        ]);

        //cs
        DB::table('users')->insert([
            'id' => 16,
            'slug' => md5(16),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Donata',
            'lname' => 'Acula',
            'email' => 'ddacula@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 17,
            'slug' => md5(17),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Jonathan',
            'lname' => 'Cabero',
            'email' => 'jbcabero@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 18,
            'slug' => md5(18),
            'prefix'=> 'Assoc. Prof.',
            'fname' => 'Perla',
            'lname' => 'Cosme',
            'email' => 'ppcosme@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 19,
            'slug' => md5(19),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Lawrence',
            'lname' => 'Decamora',
            'email' => 'lgdecamora@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 20,
            'slug' => md5(20),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Cherry Rose',
            'lname' => 'Estabillo',
            'email' => 'crestabillo@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 21,
            'slug' => md5(21),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Charmaine',
            'lname' => 'Ponay',
            'email' => 'csponay@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 22,
            'slug' => md5(22),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Janette',
            'lname' => 'Sideno',
            'email' => 'jesideno@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 23,
            'slug' => md5(23),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Edwin',
            'lname' => 'Torralba',
            'email' => 'emtorralba@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 2,
            'status' => 1
        ]);

        //it
        DB::table('users')->insert([
            'id' => 24,
            'slug' => md5(24),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Darlene',
            'lname' => 'Alberto',
            'email' => 'ddalberto@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 25,
            'slug' => md5(25),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Maricel',
            'lname' => 'Balais',
            'email' => 'mabalais@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);
        DB::table('users')->insert([
            'id' => 26,
            'slug' => md5(26),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Mylene',
            'lname' => 'Domingo',
            'email' => 'mjdomingo@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 27,
            'slug' => md5(27),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Maria Lourdes',
            'lname' => 'Edang',
            'email' => 'mledang@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 28,
            'slug' => md5(28),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Mia',
            'lname' => 'Eleazar',
            'email' => 'mveleazar@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 29,
            'slug' => md5(29),
            'prefix'=> 'Assoc. Prof',
            'fname' => 'Noel',
            'lname' => 'Estrella',
            'email' => 'neestrella@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 30,
            'slug' => md5(30),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Ma. Beatrice',
            'lname' => 'Lacsamana',
            'email' => 'mllacsamana@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 31,
            'slug' => md5(31),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Leonid',
            'lname' => 'Lintag',
            'email' => 'lclintag@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 32,
            'slug' => md5(32),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Arthur',
            'lname' => 'Ollanda',
            'email' => 'adollanda@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 33,
            'slug' => md5(33),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Alma',
            'lname' => 'Perol',
            'email' => 'avperol@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 34,
            'slug' => md5(34),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Ronina',
            'lname' => 'Tayuan',
            'email' => 'rctayuan@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 35,
            'slug' => md5(35),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Mike',
            'lname' => 'Victorio',
            'email' => 'mcvictorio@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'id' => 36,
            'slug' => md5(36),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Eugenia',
            'lname' => 'Zhuo',
            'email' => 'erzhuo@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);
        DB::table('users')->insert([
            'id' => 37,
            'slug' => md5(37),
            'prefix'=> 'Asst. Prof.',
            'fname' => 'Bernard',
            'lname' => 'Sanidad',
            'email' => 'bgsanidad@ust.edu.ph',
            'password' => Hash::make('123'),
            'type' => 1,
            'verified' => 1,
            'department' => 0,
            'status' => 1
        ]);
    }
}
