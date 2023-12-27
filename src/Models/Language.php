<?php

namespace Eclipse\Core\Models;

use Eclipse\Core\Foundation\Database\Model;

/**
 * Class Language
 *
 * @property int $id Language ID
 * @property string $name Name
 * @property string $system_locale System locale (must be available with locale -a)
 * @property string $messages_locale (Optional) Alternative messages locale, can differ from system_locale
 * @property string $laravel_lang Laravel language
 * @property string $datetime_format Strftime() datetime format
 * @property string $date_format Strftime() date format
 * @property string $time_format Strftime() time format
 * @property string $decimal_separator Number decimal separator
 * @property string $thousands_separator Number thousands separator
 * @property int $is_active Is active 0/1
 * @property int $is_ui_available Is available as an UI language 0/1
 */
class Language extends Model
{
    //use HasFactory;

    protected $table = 'core_language';
}
