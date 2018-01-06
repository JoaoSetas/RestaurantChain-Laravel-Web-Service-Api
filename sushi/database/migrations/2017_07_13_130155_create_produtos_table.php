<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoria_id');
            $table->integer('classificacao_id')->nullable();
            $table->text('produto');
            $table->text('dci_composicao')->nullable()->comment('DCI para categoria Medicamentos e OTC’s e Dispositivos Composicao para categoria Suplementos e Cosméticos');
            $table->text('forma')->nullable()->comment('Forma Farmacêutica para categoria Medicamentos e OTC’s e Dispositivos Forma +Apresentação para categoria Suplementos e Cosméticos');
            $table->text('embalagem')->nullable()->comment('Apenas para categoria Medicamentos e OTC’s e Dispositivos');
            $table->text('med_id')->nullable()->comment('Apenas para categoria Medicamentos e OTC’s e Dispositivos');
            $table->text('pais_registo')->nullable()->comment('Apenas para categoria Medicamentos e OTC’s e Dispositivos');
            $table->text('imagem')->nullable();
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
        Schema::dropIfExists('produtos');
    }
}
