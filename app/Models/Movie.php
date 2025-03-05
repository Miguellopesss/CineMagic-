<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
    ];

    public function getPosterFullUrlAttribute()
    {
        debug($this->poster_filename);

        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("storage/posters/_no_poster_1.png");
        }
    }

    public function getTrailerEmbedUrlAttribute()
    {
        if (str_contains($this->trailer_url, 'watch?v=')) {
            return str_replace('watch?v=', 'embed/', $this->trailer_url);
        } else {
            return $this->trailer_url;
        }
    }

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_code', 'code')->withTrashed();
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

}
