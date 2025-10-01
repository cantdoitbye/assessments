<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
     use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

   
       public function isAdmin(): bool
    {
        return $this->is_admin || in_array($this->role, ['master_admin', 'sub_admin']);
    }

    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    public function isSubAdmin(): bool
    {
        return $this->role === 'sub_admin';
    }

      public function userAssessments()
    {
        return $this->hasMany(UserAssessment::class);
    }
}
