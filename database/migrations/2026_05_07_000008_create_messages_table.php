<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('custom_order_id')->nullable()->constrained('custom_orders')->nullOnDelete();
            $table->string('sender_name');
            $table->text('message');
            $table->string('url_pdf')->nullable();
            $table->boolean('is_reply')->default(false);
            $table->foreignId('replied_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
