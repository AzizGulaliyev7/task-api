<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'ceo_name', 'address', 'email', 'web_site', 'phone_number'
    ];

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
