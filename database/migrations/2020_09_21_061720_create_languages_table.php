<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_language', function (Blueprint $table) {
            $table->char('id', 2)->primary();
            $table->string('name', 100);
            $table->string('system_locale', 50);
            $table->string('messages_locale', 50)->nullable();
            $table->string('laravel_lang', 20);
            $table->string('datetime_format', 50);
            $table->string('date_format', 50);
            $table->string('time_format', 50);
            $table->char('decimal_separator', 1);
            $table->char('thousands_separator', 1);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_ui_available')->default(0);
        });

        DB::table('core_language')->insert([
            'id' => 'en',
            'name' => 'English',
            'system_locale' => 'en_GB.UTF8',
            'laravel_lang' => 'en',
            'datetime_format' => '%b %d %Y, %l:%M %p',
            'date_format' => '%b %d %Y',
            'time_format' => '%l:%M %p',
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'is_ui_available' => 1,
        ]);

        DB::table('core_language')->insert([
            'id' => 'sl',
            'name' => 'Slovenščina',
            'system_locale' => 'sl_SI.UTF8',
            'laravel_lang' => 'sl',
            'datetime_format' => '%d. %b %Y, %H:%M',
            'date_format' => '%d.%m.%Y',
            'time_format' => '%H:%M',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
            'is_ui_available' => 1,
        ]);

        DB::table('core_language')->insert([
            'id' => 'hr',
            'name' => 'Hrvatski',
            'system_locale' => 'hr_HR.UTF8',
            'laravel_lang' => 'hr',
            'datetime_format' => '%d. %b %Y, %H:%M',
            'date_format' => '%d.%m.%Y',
            'time_format' => '%H:%M',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
        ]);

        DB::table('core_language')->insert([
            'id' => 'sr',
            'name' => 'Srpski',
            'system_locale' => 'sr_RS.UTF8@latin',
            'laravel_lang' => 'sr',
            'datetime_format' => '%d. %b %Y, %H:%M',
            'date_format' => '%d.%m.%Y',
            'time_format' => '%H:%M',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
        ]);

        DB::table('core_language')->insert([
            'id' => 'it',
            'name' => 'Italiano',
            'system_locale' => 'it_IT.UTF8',
            'laravel_lang' => 'it',
            'datetime_format' => '%d/%b/%Y %H:%M',
            'date_format' => '%d/%m/%Y',
            'time_format' => '%H:%M',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
        ]);

        DB::table('core_language')->insert([
            'id' => 'de',
            'name' => 'Deutsch',
            'system_locale' => 'de_DE.UTF8',
            'laravel_lang' => 'de',
            'datetime_format' => '%d.%m.%Y, %H:%M',
            'date_format' => '%d.%m.%Y',
            'time_format' => '%H:%M',
            'decimal_separator' => ',',
            'thousands_separator' => '.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_language');
    }
}
