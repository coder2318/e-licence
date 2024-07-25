<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_COUNCIL = 'council';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'f_name',
        'l_name',
        's_name',
        'avatar',
        'pin',
        'tin',
        'passport',
        'data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'data' => 'array'
    ];

    public static function getUserRoleNames(): array
    {
        if(Auth::check())
            return Auth::user()->getRoleNames()->toArray();
        return [];
    }

    public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->getUserRoleNames());
    }

    public function isCouncil(): bool
    {
        return in_array(self::ROLE_COUNCIL, $this->getUserRoleNames());
    }

    public function isUser(): bool
    {
        return in_array(self::ROLE_USER, $this->getUserRoleNames());
    }

    public function isModerator(): bool
    {
        return in_array(self::ROLE_MODERATOR, $this->getUserRoleNames());
    }

}
