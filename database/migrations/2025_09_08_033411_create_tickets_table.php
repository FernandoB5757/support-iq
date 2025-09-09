<?php

use App\Models\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained();
            $table->string('subject');
            $table->text('body');
            $table->text('explanation')->nullable();
            $table->float('confidence')->nullable();
            $table->enum('status', TicketStatus::values())
                ->default(TicketStatus::OPEN->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
