<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->integer('id_funcionario');
            $table->primary(['id_funcionario']);
            $table->integer('empresa_id')->unsigned();
            $table->string('nome');
            $table->date('data_transacao');
            $table->smallInteger('status')->default(1)->comment('1 - Ativo, 2 - Inativo');
            $table->timestamps();
        });

        Schema::table('funcionarios', function(Blueprint $table) {
            $table->foreign('empresa_id')->references('id_empresa')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
