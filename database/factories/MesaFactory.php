<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MesaFactory extends Factory
{
    protected static $numero = 1;

    public function definition(): array
    {
        return [
            'descricao' => 'Mesa ' . self::$numero++,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
