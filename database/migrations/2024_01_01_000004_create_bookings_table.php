<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('field_id')->constrained('fields')->onDelete('restrict');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('duration_hours');
            $table->decimal('total_price', 12, 2);
            $table->string('payment_proof', 255)->nullable();
            $table->enum('status', [
                'menunggu_pembayaran',
                'terkonfirmasi',
                'dibatalkan',
                'selesai',
                'refund',
            ])->default('menunggu_pembayaran');
            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
