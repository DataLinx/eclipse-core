<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_app_instance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')
                ->constrained('core_site')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('app_package_id')
                ->constrained('core_package')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('path');
            $table->boolean('is_active');
        });

        Schema::create('core_app_instance_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_instance_id')
                ->constrained('core_app_instance')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->char('language_id', 2)
                ->constrained('core_language')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('is_default');
            $table->unsignedSmallInteger('sort_num')->nullable();
            $table->unsignedSmallInteger('fallback_sort_num')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_app_instance_language');
        Schema::dropIfExists('core_app_instance');
    }
}
