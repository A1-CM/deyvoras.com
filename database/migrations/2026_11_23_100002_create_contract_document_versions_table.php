<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('version_number');
            $table->string('document_path');
            $table->string('document_name');
            $table->timestamps();
            $table->unique(['contract_id', 'version_number']);
        });

        DB::table('contracts')->whereNotNull('document_path')->orderBy('id')->lazy()->each(function (object $contract): void {
            DB::table('contract_document_versions')->insert([
                'contract_id' => $contract->id,
                'uploaded_by' => $contract->created_by,
                'version_number' => 1,
                'document_path' => $contract->document_path,
                'document_name' => $contract->document_name ?? basename($contract->document_path),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_document_versions');
    }
};
