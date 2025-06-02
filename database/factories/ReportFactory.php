<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'reporter_id' => User::factory(),
            'reported_id' => User::factory(),
            'reason' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'reviewed']),
        ];
    }
}
