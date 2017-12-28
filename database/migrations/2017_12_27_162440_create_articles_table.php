<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id'); //o id incrementa automaticamente
            $table->string('title');//cria uma coluna varchar
            $table->text('body');//cria a coluna  de text
            $table->timestamps();//hora-o laravel atualiza
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');//deixa a tabela de ela existir
    }
}
