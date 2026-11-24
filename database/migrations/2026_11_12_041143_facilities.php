<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['gedung', 'ruangan', 'barang']);
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('facilities')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('facility_categories')->nullOnDelete();
            $table->string('location')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('stock_total')->nullable();
            $table->unsignedInteger('stock_damaged')->default(0);
            $table->enum('condition', ['baik', 'rusak', 'pemeliharaan'])->default('baik');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->string('responsible')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
