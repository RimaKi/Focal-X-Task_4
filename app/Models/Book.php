<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author_id',
        'description',
        'published_at'
    ];
    protected $appends = [
        'averageRate'
    ];

    public function getAverageRateAttribute()
    {
        $rates = $this->rates()->average('rating');
        return $rates;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function borrow_records()
    {
        return $this->hasMany(Borrow_record::class);
    }
}
