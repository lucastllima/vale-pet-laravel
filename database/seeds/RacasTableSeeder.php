<?php

use Illuminate\Database\Seeder;

class RacasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('racas')->insert([
            //Outro
            ['nome' => 'Outro', 'tipo' => '0'],
            
            //Cachorro
            ['nome' => 'Dachshund', 'tipo' => '1'],
            ['nome' => 'Chihuahua', 'tipo' => '1'],
            ['nome' => 'Pinscher', 'tipo' => '1'],
            ['nome' => 'Shih Tzu', 'tipo' => '1'],
            ['nome' => 'Yorkshire', 'tipo' => '1'],
            ['nome' => 'Poodle', 'tipo' => '1'],
            ['nome' => 'SRD', 'tipo' => '1'],
            ['nome' => 'Golden', 'tipo' => '1'],
            ['nome' => 'Pastor Alemão', 'tipo' => '1'],
            ['nome' => 'Labrador', 'tipo' => '1'],
            ['nome' => 'Bulldog', 'tipo' => '1'],
            ['nome' => 'Pug', 'tipo' => '1'],
            ['nome' => 'Outro', 'tipo' => '1'],

            //Gato
            ['nome' => 'Siamês', 'tipo' => '2'],
            ['nome' => 'Angorá', 'tipo' => '2'],
            ['nome' => 'Persa', 'tipo' => '2'],
            ['nome' => 'SRD', 'tipo' => '2'],
            ['nome' => 'Outro', 'tipo' => '2']
            

        ]);
    }
}
