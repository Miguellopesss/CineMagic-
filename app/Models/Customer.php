<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nif',
        'payment_type',
        'payment_ref',
    ];

    public function users(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'id');
    }

    public function purchases(): HasMany
    {
        return $this->HasMany(Purchase::class);
    }

}
