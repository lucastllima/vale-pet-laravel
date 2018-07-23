<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('situacao')->default(false);// 0: Não Adotado --  2: Adotado
            $table->integer('tipo_animal');// 0: Outro -- 1: Cachorro --  2: Gato
            $table->integer('idade_animal'); // 1: 1 a 6 meses --  2: 7 a 12 meses -- 3: 1 a 3 anos -- 4: Acima de 3 anos
            $table->integer('sexo_animal');// 1: Fêmea --  2: Macho
            $table->string('nome_animal')->nullable();
            $table->string('telefone');
            $table->boolean('iswhatsapp')->default(false);
            $table->boolean('iscastrado')->default(false);
            $table->boolean('isvacinado')->default(false);
            
            #--> Relacionamentos
            $table->integer('user_id')->unsigned();
            $table->integer('cidade_id')->unsigned();
            $table->integer('raca_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
