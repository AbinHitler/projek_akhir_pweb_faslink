<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pengajuan peminjaman dan dokumen pendukungnya.
     */
    public function up(): void
    {
        if (! Schema::hasTable('loans')) {
            Schema::create('loans', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('activity_name', 150);
                $table->string('organization', 150)->nullable();
                $table->text('description');
                $table->string('responsible_name', 150);
                $table->string('responsible_contact', 30);
                $table->unsignedInteger('participant_count');
                $table->dateTime('start_at');
                $table->dateTime('end_at');
                $table->string('facility_name', 150);
                $table->unsignedInteger('quantity')->default(1);
                $table->text('additional_notes')->nullable();
                $table->string('status', 20)->default('pending');
                $table->text('rejection_note')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamps();

                $table->index(['status', 'start_at']);
                $table->index('facility_name');
            });
        }

        if (! Schema::hasTable('loan_documents')) {
            Schema::create('loan_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('loan_id')->constrained('loans')->cascadeOnDelete();
                $table->string('original_name');
                $table->string('file_path');
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_documents');
        Schema::dropIfExists('loans');
    }
};
