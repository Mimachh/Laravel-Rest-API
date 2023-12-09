<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        "last_name",
        'email',
        'password',
        'terms',
        'avatar'
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

    protected $dates = ['delete_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($role) {
        return $this->roles()->where('name', $role)->first() !== null;
    }

    public function hasAnyRole($roles) {
        return $this->roles()->whereIn('name', $roles)->first() !== null;
    }


    // A la création
    protected static function boot()
    {
        parent::boot();
    
        self::created(function ($user) {
            $user->roles()->attach(3);
        });
    }



    //  SITES
    public function sites()
    {
        return $this->belongsToMany(Site::class)->withTimestamps();
    }


    // IS SUPER ADMIN
            /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->roles->contains('name', 'Super Admin');
    }

    // IS ADMIN
        /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->roles->contains('name', 'Admin');
    }
}
