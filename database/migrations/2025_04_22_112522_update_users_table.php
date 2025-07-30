<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_info')->nullable();
            $table->string('default_address')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_expiry')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'contact_info',
                'default_address',
                'password_reset_token',
                'password_reset_token_expiry',
                'is_admin'
            ]);
        });
    }    
};
