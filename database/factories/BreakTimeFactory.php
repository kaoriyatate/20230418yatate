<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BreakTime;
use App\Models\Attendance;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Break_time>
 */
class BreakTimeFactory extends Factory
{

     protected $model = BreakTime::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //public function definition(): array
    //{

    public function definition()
     { 
        $faker = FakerFactory::create();
        
        $break_start_time = $faker->time('Y-m-d H:i:s');
        $break_end_time = date('Y-m-d H:i:s', strtotime($break_start_time) + rand(1, 10) * 3600);
    
        return [
            'break_start_time' => $break_start_time,
            'break_end_time' => $break_end_time,
            'attendance_id' => function () {
                return Attendance::factory()->create()->id;
            },
        ];
        
    }
}
