<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function spaces_owned()
    {
        return $this->hasMany(Space::class, 'created_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'created_by');
    }

    public function spaces()
    {
        return $this->belongsToMany(Space::class);
    }

    public function trips2()
    {
        return $this->belongsToMany(Trip::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
