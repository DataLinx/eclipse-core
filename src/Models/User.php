<?php

namespace SDLX\Core\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use SDLX\Core\Database\Factories\UserFactory;

/**
 * Class User
 *
 * @package SDLX\Core\Models
 *
 * @property int $id User ID
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'core_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'seen_at' => 'datetime',
    ];

    /**
     * Delete user's image, if set
     */
    public function deleteImage()
    {
        if (empty($this->image)) {
            return;
        }

        // Delete file from filesystem
        $file = storage_path('app/'. $this->image);

        if (file_exists($file)) {
            unlink($file);
        }

        // Delete from cache
        app()->glide->deleteCache($this->image);

        // Clear the attribute
        $this->image = null;
        $this->save();
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

    /**
     * @inheritDoc
     */
    public static function query(): Builder
    {
        $query = parent::query();

        $query->select('core_user.*')
            ->addSelect(DB::raw("CONCAT(core_user.name, ' ', core_user.surname) AS full_name"));

        return $query;
    }
}
