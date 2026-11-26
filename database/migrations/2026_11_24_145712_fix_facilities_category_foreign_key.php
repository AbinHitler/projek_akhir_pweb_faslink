<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pastikan foreign key kategori dan index jenis/status tersedia.
     * Dibuat idempotent karena migrasi facilities bisa saja sudah
     * membuat keduanya lebih dulu.
     */
    public function up(): void
    {
        if (! Schema::hasTable('facilities')) {
            return;
        }

        $hasCategoryForeignKey = collect(Schema::getForeignKeys('facilities'))
            ->contains(fn (array $foreignKey) => $foreignKey['columns'] === ['category_id']
                && $foreignKey['foreign_table'] === 'facility_categories');

        $hasTypeStatusIndex = collect(Schema::getIndexes('facilities'))
            ->contains(fn (array $index) => $index['columns'] === ['type', 'status']);

        Schema::table('facilities', function (Blueprint $table) use ($hasCategoryForeignKey, $hasTypeStatusIndex) {
            if (! $hasCategoryForeignKey) {
                $table->foreign('category_id')
                    ->references('id')
                    ->on('facility_categories')
                    ->nullOnDelete();
            }

            if (! $hasTypeStatusIndex) {
                $table->index(['type', 'status']);
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus apa pun: foreign key/index kemungkinan dibuat
        // oleh migrasi facilities, bukan oleh migrasi ini.
    }
};
