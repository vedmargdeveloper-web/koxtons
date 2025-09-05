<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageAltColumnsToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
    {
        // slides table में image_alt जोड़ना
        Schema::table('slides', function (Blueprint $table) {
            $table->string('image_alt')->nullable()->after('image');
        });

        // categories table में feature_image_alt जोड़ना
        Schema::table('categories', function (Blueprint $table) {
            $table->string('feature_image_alt')->nullable()->after('feature_image');
        });

        // our_clients table में image_alt जोड़ना
        Schema::table('our_clients', function (Blueprint $table) {
            $table->string('image_alt')->nullable()->after('image');
        });

        Schema::table('product_meta_colors', function (Blueprint $table) {
            $table->string('color_image_alt')->nullable()->after('images');
        });

    }

    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('feature_image_alt');
        });

        Schema::table('our_clients', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });
          Schema::table('product_meta_colors', function (Blueprint $table) {
            $table->dropColumn('color_image_alt');
        });
    }
}
