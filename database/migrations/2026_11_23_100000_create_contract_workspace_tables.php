<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('document_type')->default('Other');
            $table->string('counterparty')->nullable();
            $table->string('contract_number')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->unsignedSmallInteger('notice_days')->nullable();
            $table->string('status')->default('active');
            $table->string('review_status')->default('needs_review');
            $table->text('summary')->nullable();
            $table->string('document_path')->nullable();
            $table->string('document_name')->nullable();
            $table->timestamps();
            $table->index(['organization_id', 'status']);
            $table->index(['organization_id', 'expiry_date']);
        });

        Schema::create('contract_clauses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('notes')->nullable();
            $table->string('verification_status')->default('unverified');
            $table->timestamps();
        });

        Schema::create('contract_obligations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('responsible_name')->nullable();
            $table->date('due_at')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
            $table->index(['status', 'due_at']);
        });

        Schema::create('contract_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_activities');
        Schema::dropIfExists('contract_obligations');
        Schema::dropIfExists('contract_clauses');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('organizations');
    }
};
