<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_logs', 'document_id')) {
                $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('cascade');
            }
            if (!Schema::hasColumn('audit_logs', 'action')) {
                $table->string('action');
            }
            if (!Schema::hasColumn('audit_logs', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }
            if (!Schema::hasColumn('audit_logs', 'user_agent')) {
                $table->text('user_agent')->nullable();
            }
            if (!Schema::hasColumn('audit_logs', 'metadata')) {
                $table->json('metadata')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['document_id']);
            $table->dropColumnIfExists(['document_id', 'action', 'ip_address', 'user_agent', 'metadata']);
        });
    }
};