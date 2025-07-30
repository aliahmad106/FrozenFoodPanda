<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false);
            }
            if (!Schema::hasColumn('products', 'is_popular')) {
                $table->boolean('is_popular')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'featured')) {
                $table->dropColumn('featured');
            }
            if (Schema::hasColumn('products', 'is_popular')) {
                $table->dropColumn('is_popular');
            }
        });
    }
};
