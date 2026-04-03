<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'mobile_no',
    'base_mobile',
    'country_id',
    'dial_code',
    'email',
    'otp_code',
    'company_name',
    'package',
    'amount',
    'payment_type',
    'payed_at',
    'payment_status',
    'gst_no',
    'payment_screenshort',
    'otp_verifed_at',
    'otp_expired_at',
    'email_verified_at',
    'is_active',
    'created_by',
    'updated_by',
])]
#[Hidden(['otp_code', 'payment_screenshort'])]
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payed_at' => 'datetime',
            'otp_verifed_at' => 'datetime',
            'otp_expired_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the country associated with the customer.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user who created the customer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the customer.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
