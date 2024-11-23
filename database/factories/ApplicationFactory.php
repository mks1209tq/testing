<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\NoticePeriodDays;
use App\Models\Vacancy;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'vacancy_id' => Vacancy::factory(),
            'notice_period_days' => NoticePeriodDays::factory(),
        ];
    }
}
