<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
    ];

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    public function movies(): HasMany
    {
        return $this->HasMany(Movie::class, 'genre_code', 'code');
    }


}
