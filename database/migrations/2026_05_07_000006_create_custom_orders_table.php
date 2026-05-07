<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('track_id_pos')->nullable();
            $table->string('track_id_store')->nullable();
            $table->string('customer_email');
            $table->string('qty');
            $table->text('subject');
            $table->text('notes')->nullable();
            $table->string('reference_file')->nullable();
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('fulfilled_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};
