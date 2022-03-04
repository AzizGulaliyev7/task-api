<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $user = Auth::user();
        if ($user->role == 'company') {
            static::addGlobalScope('role', function (Builder $builder) use($user) {
                $builder->whereHas('company', function (Builder $query) use($user) {
                    $query->where('user_id', $user->id);
                });
            });
        }
    }

    protected $fillable = [
        'company_id', 'passport_number', 'last_name', 'first_name', 'middle_name', 'position', 'phone_number', 'address'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
