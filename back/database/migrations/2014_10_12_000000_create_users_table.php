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
            $table->bigIncrements('id');
            $table->string('username');
//            $table->string('email')->unique();
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('type_id')->default(2);
            $table->rememberToken();
//            $table->foreignId('current_team_id')->nullable();
//            $table->text('profile_photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('user_types');

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
