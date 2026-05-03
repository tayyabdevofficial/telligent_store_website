<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Expired = 'expired';
    case Refunded = 'refunded';

    public function label(): string
    {
        return str($this->value)->replace('_', ' ')->title()->toString();
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Paid => 'bg-emerald-50 text-emerald-700',
            self::Failed => 'bg-rose-50 text-rose-700',
            self::Refunded, self::Expired => 'bg-amber-50 text-amber-700',
            self::Pending => 'bg-sky-50 text-sky-700',
        };
    }
}
