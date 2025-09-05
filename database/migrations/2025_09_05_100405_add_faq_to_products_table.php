<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFaqToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('faq')->nullable()->after('content'); 
            $table->text('feature_image_alt')->nullable()->after('feature_image'); 
            $table->text('file_alt')->nullable()->after('feature_image_alt'); 
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('faq');
            $table->dropColumn('feature_image_alt');
            $table->dropColumn('file_alt');
        });
    }
}
