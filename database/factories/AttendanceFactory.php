<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;




/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{

    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    ///public function definition(): array
    //{

    public function definition()
     {  
        $faker = FakerFactory::create();
        
        $start_time = $faker->time('H:i:s');
        $end_time = date('H:i:s', strtotime($start_time) + rand(1, 10) * 3600);

        return [
            'attendance_date' => $faker->dateTimeBetween('-1   month', 'now'),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }    
}

