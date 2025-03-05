<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'seat_id',
        'purchase_id',
        'price',
        'qrcode_url',
        'status',
        'id',
    ];

    public function seats(): BelongsTo
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'id');
    }
    public function screenings(): BelongsTo
    {
        return $this->belongsTo(Screening::class, 'screening_id', 'id');
    }
    public function purchases(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

}
