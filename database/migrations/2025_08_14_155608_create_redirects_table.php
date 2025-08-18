<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('redirect', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('old_url')->unique();
        $table->string('new_url');
        $table->integer('status_code')->default(301); // Permanent redirect
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
        Schema::dropIfExists('redirect');
    }
}
