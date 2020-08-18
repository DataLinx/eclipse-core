<?php

namespace Ocelot\Core\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package Ocelot\Core\Models
 *
 * @property int $id User ID
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'cr_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'seen_at' => 'datetime',
    ];

    /**
     * Get full name for user
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->name .' '. $this->surname;
    }
}
