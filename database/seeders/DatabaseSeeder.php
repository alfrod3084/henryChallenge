<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Location;
use App\Models\Patient;
use App\Models\Rule;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt("Pa55word"),
            'role' => "staff",
            'created_at' => Carbon::now(),
        ]);

        // Create requested rule in demo
        Rule::create([
            'actions' => json_encode([
                'action' => "submit_form",
                'rules' => [
                    [
                        'field' => "role",
                        'operator' => "==",
                        'value' => "staff"
                    ],
                    [
                        'field' => "email_verified_at",
                        'operator' => "!=",
                        'value' => null
                    ]
                ]
            ]),
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        //Create some locations
        Location::create([
            'city' => "NEW YORK",
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
        $location = Location::create([
            'city' => "DALLAS",
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        //Create some patients
        Patient::create([
            'name' => "ALFREDO",
            'last_name' => "RODRIGUEZ",
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
        $patient = Patient::create([
            'name' => "JOHN",
            'last_name' => "WILLIAMS",
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        //Create some appointments
        Appointment::create([
            'title' => "Meeting with the team",
            'id_patient' => $patient->id_patient,
            'id_location' => $location->id_location,
            'status' => 'draft'
        ]);

        Appointment::create([
            'title' => "Meeting with family",
            'id_patient' => $patient->id_patient,
            'id_location' => $location->id_location,
            'status' => 'confirmed'
        ]);

        Appointment::create([
            'title' => "Meeting with CEO",
            'id_patient' => $patient->id_patient,
            'id_location' => $location->id_location,
            'status' => 'pending'
        ]);
    }
}
