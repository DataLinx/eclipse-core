<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_site', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 100);
            $table->string('name', 100);
            $table->boolean('is_active');
            $table->boolean('is_main');
            $table->boolean('is_secure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_site');
    }
}
