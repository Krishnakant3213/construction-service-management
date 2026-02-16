<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_number', 20)->unique();
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone', 20);
            $table->string('client_company')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->foreignId('lead_source_id')->constrained('lead_sources')->restrictOnDelete();
            $table->string('status')->default('new'); // new, contacted, site_visit_scheduled, quotation_sent, negotiation, won, lost
            $table->string('priority')->default('medium'); // low, medium, high
            $table->text('requirement_description')->nullable();
            $table->decimal('estimated_budget', 12, 2)->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->date('follow_up_date')->nullable();
            $table->string('lost_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('assigned_to');
            $table->index('lead_source_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
