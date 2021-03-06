<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('firstname', 50)->nullable();
            $table->string('lastname')->nullable();
            $table->string('gender', 50)->nullable(); // الجنس
            $table->string('marital_status')->nullable(); // الحالة الإجتماعية
            $table->string('birth_date')->nullable(); //birth_date 
            $table->string('country')->nullable();
            $table->string('user_type')->nullable();
            $table->string('otp')->nullable();
            $table->string('email')->unique();
            $table->string('api_token', 60)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('avatar')->nullable();
            $table->integer("email_verified")->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
