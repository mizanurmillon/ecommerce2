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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->boolean('is_admin')->nullable();
            $table->string('avatar')->nullable();
            $table->string('provider',20)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('category')->default(0)->nullable();
            $table->string('product')->default(0)->nullable();
            $table->string('offer')->default(0)->nullable();
            $table->string('order')->default(0)->nullable();
            $table->string('blog')->default(0)->nullable();
            $table->string('pickup')->default(0)->nullable();
            $table->string('ticket')->default(0)->nullable();
            $table->string('contact')->default(0)->nullable();
            $table->string('report')->default(0)->nullable();
            $table->string('setting')->default(0)->nullable();
            $table->string('userrole')->default(0)->nullable();
            $table->string('access_token')->nullable();
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
