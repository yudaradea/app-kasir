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
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('id_kategory')
            ->unsigned()
                 ->change();
            $table->foreign('id_kategory')
                ->references('id')
                ->on('categories')
                ->onUpdate('restrict')
                ->onDelete('restrict');     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            
            $table->dropForeign('products_id_kategory_foreign');
        });
    }
};
