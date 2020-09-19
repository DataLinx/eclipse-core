<?php

namespace Ocelot\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ocelot\Core\Database\Factories\UserFactory;

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
    use HasFactory, Notifiable;

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

    /**
     * Fetch User by email
     *
     * @param string $email User email
     * @return User
     */
    public static function fetchByEmail($email)
    {
        return self::where('email', $email)->firstOrFail();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return UserFactory
     */
    public static function newFactory()
    {
        return UserFactory::new();
    }
}
