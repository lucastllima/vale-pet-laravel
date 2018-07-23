<?php

use Illuminate\Database\Seeder;

class CidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::SELECT(DB::raw(

            "INSERT INTO `cidades` (`id`, `nome`, `uf`) VALUES
                (1, 'Petrolina', 'PE'),
                (2, 'Juazeiro', 'BA');"

        ));
    }
}
