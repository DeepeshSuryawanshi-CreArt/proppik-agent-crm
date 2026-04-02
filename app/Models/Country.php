<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'dial_code',
    ];

    public $timestamps = false;

    /**
     * Get the users for the country.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
