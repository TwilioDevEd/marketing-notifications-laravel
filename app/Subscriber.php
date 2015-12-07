<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['phone_number', 'subscribed'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
