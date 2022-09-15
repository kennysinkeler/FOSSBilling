<?php

namespace Database\Factories;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first_name =$this->faker->firstName();
        $last_name  = $this->faker->lastName();
        return [
            'first_name' => $first_name,
            'last_name' =>$last_name,
            'auth_type'=> "local",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'type'=>"client",
            'gender'=> 'other',
            'company'=> $this->faker->company(),
            'phone_cc'=> "0",
            'email' => $first_name.".".$last_name."@example.com",
            'created_at' => $this->faker->dateTime()
        ];
    }
}
