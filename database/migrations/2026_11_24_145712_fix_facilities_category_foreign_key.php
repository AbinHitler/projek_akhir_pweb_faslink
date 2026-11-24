
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('facility_categories')
                ->nullOnDelete();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['type', 'status']);
        });
    }
};
