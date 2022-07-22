<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'space_id',
        'name',
        'description',
        'from_date',
        'to_date',
        'created_by',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
