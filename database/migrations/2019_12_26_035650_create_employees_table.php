<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('position');
            $table->char('iin', 12)->unique();
            $table->char('phone', 12);//+77023460080
            $table->integer('job_experience_months');//??how
            $table->smallInteger('from_year')->nullable();
            $table->smallInteger('to_year')->nullable();
            $table->enum('evaluation', ['низкий', 'справедливо', 'удовлетворительное', 'хорошо', 'отлично']);
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
        Schema::dropIfExists('employees');
    }
}
