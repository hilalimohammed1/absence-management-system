<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'Teacher',
        ]);

        $groups = collect([
            ['group_name' => 'Web Development A', 'description' => 'Laravel and frontend fundamentals.'],
            ['group_name' => 'Network Systems B', 'description' => 'Networking and operating systems.'],
            ['group_name' => 'Digital Design C', 'description' => 'Design tools and UI basics.'],
        ])->map(fn (array $data) => Group::create($data));

        $students = collect([
            ['first_name' => 'Amina', 'last_name' => 'Bennani', 'email' => 'amina.bennani@example.com', 'phone' => '0600000001', 'group_id' => $groups[0]->id],
            ['first_name' => 'Youssef', 'last_name' => 'El Amrani', 'email' => 'youssef.elamrani@example.com', 'phone' => '0600000002', 'group_id' => $groups[0]->id],
            ['first_name' => 'Sara', 'last_name' => 'Karim', 'email' => 'sara.karim@example.com', 'phone' => '0600000003', 'group_id' => $groups[1]->id],
            ['first_name' => 'Omar', 'last_name' => 'Naciri', 'email' => 'omar.naciri@example.com', 'phone' => '0600000004', 'group_id' => $groups[1]->id],
            ['first_name' => 'Hiba', 'last_name' => 'Fassi', 'email' => 'hiba.fassi@example.com', 'phone' => '0600000005', 'group_id' => $groups[2]->id],
            ['first_name' => 'Mehdi', 'last_name' => 'Rami', 'email' => 'mehdi.rami@example.com', 'phone' => '0600000006', 'group_id' => $groups[2]->id],
        ])->map(fn (array $data) => Student::create($data));

        foreach (range(0, 4) as $daysAgo) {
            $date = Carbon::now()->subDays($daysAgo)->toDateString();

            foreach ($students as $index => $student) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $date,
                    'status' => ($index + $daysAgo) % 4 === 0 ? 'Absent' : 'Present',
                ]);
            }
        }
    }
}
