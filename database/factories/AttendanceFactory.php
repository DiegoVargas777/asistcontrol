<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'user_id'   => User::factory(),
            'date'      => $this->faker->date(),
            'check_in'  => $this->faker->time('H:i:s'),
            'check_out' => $this->faker->time('H:i:s'),
        ];
    }
}