<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConversionTest extends TestCase
{

    public function test_convert_kilometers_to_light_years()
    {
        $response = $this->postJson('/api/quilometros', [
            'quilometros' => 9460730472580.8
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'anosLuz' => 1
            ]);
    }

    public function test_convert_light_years_to_kilometers()
    {
        $response = $this->postJson('/api/anosLuz', [
            'anosLuz' => 1
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'quilometros' => 9460730472580.8
            ]);
    }


    public function test_invalid_kilometers_input()
    {
        $response = $this->postJson('/api/quilometros', [
            'quilometros' => -100
        ]);

        $response->assertStatus(400);
    }


    public function test_invalid_light_years_input()
    {
        $response = $this->postJson('/api/anosLuz', [
            'anosLuz' => -1
        ]);

        $response->assertStatus(400);
    }
}
