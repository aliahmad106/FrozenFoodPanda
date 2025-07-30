<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableWithManagementFields extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                      ->default('pending');
            }
            
            if (!Schema::hasColumn('orders', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }
            
            if (!Schema::hasColumn('orders', 'status_updated_at')) {
                $table->timestamp('status_updated_at')->nullable();
            }
            
            // If status column exists but needs to be modified
            if (Schema::hasColumn('orders', 'status')) {
                // Drop the existing status column
                $table->dropColumn('status');
            }
            // Add the new status column with updated enum values
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'])
                  ->default('pending');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'admin_notes', 'status_updated_at']);
            // Restore original status column if needed
            $table->dropColumn('status');
            $table->string('status')->default('pending');
        });
    }
}