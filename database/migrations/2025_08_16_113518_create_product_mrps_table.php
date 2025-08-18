<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMrpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
        {
            Schema::create('product_mrps', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model')->nullable();
                $table->string('item_name')->nullable();
                $table->integer('qty')->nullable();
                $table->string('qty_metric')->nullable(); // Unit, Piece, Pair, etc
                $table->string('size')->nullable();
                $table->string('code')->nullable();
                $table->date('mfg_date')->nullable();
                $table->decimal('mrp', 10, 2)->nullable();
                $table->string('barcode')->nullable();
                $table->string('paper_size')->nullable();
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_mrps');
    }
}
