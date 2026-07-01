<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('documents', 'file_name')) {
                $table->string('file_name');
            }
            if (!Schema::hasColumn('documents', 'file_path')) {
                $table->string('file_path');
            }
            if (!Schema::hasColumn('documents', 'file_type')) {
                $table->string('file_type');
            }
            if (!Schema::hasColumn('documents', 'file_size')) {
                $table->integer('file_size');
            }
            if (!Schema::hasColumn('documents', 'encryption_key')) {
                $table->string('encryption_key')->nullable();
            }
            if (!Schema::hasColumn('documents', 'status')) {
                $table->string('status')->default('published');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumnIfExists(['description', 'file_name', 'file_path', 'file_type', 'file_size', 'encryption_key', 'status']);
        });
    }
};