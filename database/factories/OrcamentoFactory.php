<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\Vendedor;


class OrcamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_cliente' => Cliente::pluck('id')->random(),
            'id_vendedor' => Vendedor::pluck('id')->random(),
            'descricao' => $this->faker->sentence(),
            'valor' => $this->faker->randomFloat(2, 0),
            'data_do_orcamento' => $this->faker->date(),
        ];
    }
}
