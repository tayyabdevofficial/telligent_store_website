<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentLink extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'amount',
        'currency',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'payment_link_slug', 'slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
