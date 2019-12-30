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
            $table->string('position')->nullable();
            $table->char('iin', 12)->unique();
            $table->char('phone', 12)->nullable();
            $table->integer('job_experience_months')->default(0);
            $table->smallInteger('from_year')->nullable();
            $table->smallInteger('to_year')->nullable();
            $table->enum('evaluation', ['низкий', 'справедливо', 'удовлетворительное', 'хорошо', 'отлично']);
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unsignedBigInteger('base_id');
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');
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
