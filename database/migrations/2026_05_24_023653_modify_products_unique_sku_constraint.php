<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Vaciar las tablas de productos y movimientos
        Schema::disableForeignKeyConstraints();
        \App\Models\Movement::truncate();
        \App\Models\Product::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Modificar la restricción única de SKU para que sea por usuario
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_sku_unique');
            $table->unique(['user_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_user_id_sku_unique');
            $table->unique('sku');
        });
    }
};
