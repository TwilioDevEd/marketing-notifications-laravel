<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['phone_number', 'subscribed'];

    public function getPhoneNumberAttribute() {
        return $this->attributes['phone_number'];
    }

    public function setPhoneNumberAttribute($value) {
        $this->attributes['phone_number'] = $value;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
