<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('fields')->onDelete('restrict');
            $table->date('slot_date');
            $table->tinyInteger('slot_hour')->comment('8-22');
            $table->decimal('price', 10, 2);

            // Unique constraint: 1 lapangan hanya bisa 1 booking per slot per tanggal
            $table->unique(['field_id', 'slot_date', 'slot_hour'], 'uk_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_slots');
    }
};
