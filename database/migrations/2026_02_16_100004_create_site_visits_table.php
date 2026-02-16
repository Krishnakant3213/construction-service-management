<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visit_number', 20)->unique();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('visit_status')->default('scheduled'); // scheduled, in_progress, completed, cancelled, rescheduled
            $table->text('site_address');
            $table->text('visit_notes')->nullable();
            $table->json('measurements')->nullable();
            $table->json('photos')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('lead_id');
            $table->index('assigned_to');
            $table->index('scheduled_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
