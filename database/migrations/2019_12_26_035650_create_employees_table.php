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
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('lastname')->nullable();

            $table->string('iin', 12)->unique();
            $table->char('phone', 22)->nullable();
            $table->integer('job_experience_months')->default(0);
            $table->smallInteger('from_year')->nullable();
            $table->smallInteger('to_year')->nullable();
            $table->enum('evaluation', ['низкий', 'справедливо', 'удовлетворительное', 'хорошо', 'отлично']);

            $table->timestamp('dateOfEmployment')->nullable();
            $table->timestamp('dateOfDismissal')->nullable();
            $table->string('reasonForDismissal')->nullable();
            $table->string('comments')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unsignedBigInteger('base_id')->nullable();
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');

            $table->string('position')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');

            $table->string('citizenship')->nullable();
            $table->unsignedBigInteger('citizenship_id')->nullable();
            $table->foreign('citizenship_id')->references('id')->on('citizenships')->onDelete('cascade');

            $table->string('status')->nullable();
            $table->unsignedBigInteger('employee_status_id')->nullable();
            $table->foreign('employee_status_id')->references('id')->on('employee_statuses')->onDelete('cascade');
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
