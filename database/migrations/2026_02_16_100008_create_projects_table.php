<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_number', 20)->unique();
            $table->foreignId('quotation_id')->constrained('quotations')->restrictOnDelete();
            $table->foreignId('lead_id')->constrained('leads')->restrictOnDelete();
            $table->string('project_name');
            $table->foreignId('project_manager')->nullable()->constrained('users')->nullOnDelete();
            $table->date('start_date');
            $table->date('expected_end_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->string('status')->default('not_started'); // not_started, in_progress, on_hold, completed, cancelled
            $table->tinyInteger('progress_percentage')->default(0);
            $table->decimal('total_value', 12, 2);
            $table->text('site_address');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('project_manager');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
