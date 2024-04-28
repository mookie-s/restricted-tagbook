<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['cover'];

    protected $dates = ['deleted_at'];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
